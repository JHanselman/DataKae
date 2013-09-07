<?php
/*
 *Class that runs a script to recalculate the Glicko 2 ranking.
 *
 */
 
define('factor', 400/log(10));  //Constant to transfer from the Glicko 1 scale to the Glicko 2 scale.
define('TAU',0.5);              //Constant that determines the change in volatility.

class RankingCalculator
{
    //Calculates ranking for all players in the database.
    public function Rank()
    {
        //Find all players that want to be ranked
        $criteria=new CDbCriteria(); 
        $criteria->condition = "\"Ranked\"=TRUE";
        $players=User::model()->findAll($criteria);
        $bla=array();
        
        
        foreach($players as $player)
        {
            $opponents=array();
        
            //Find all matches played by the player.
            $playedMatches = $player->matchData;
            
            //For each played match
            foreach($playedMatches as $playedMatch)
            {
                //Find all players participating in the match.
                $match=Match::model()->findByPk($playedMatch->matchId);
                $PlayersInMatch=$match->matchData;
                
                foreach($PlayersInMatch as $PlayerInMatch)
                {
                    //Check if the player was an opponent
                    if ($PlayerInMatch->userId!=$playedMatch->userId)
                    {
                        //Find the opponent's Glicko data.
                        $OppGlicko=GlickoData::model()->findByAttributes(array('userId' => $PlayerInMatch->userId, 'matchType' => '1v1'));
                        
                        //Calculate the score
                        $score = ($playedMatch->score>$PlayerInMatch->score) ? 1 : ($playedMatch->score==$PlayerInMatch->score ? 0.5 : 0);  
                        
                        //Add opponent to the opponent list
                        $opponents[]=new Opponent(($OppGlicko->rating-1500)/factor,($OppGlicko->RD)/factor, $score);
                    }
                }
            }
            
            //Calculate a player's new ranking
            $glicko= $player->glickoData;
            $p = new Player(($glicko->rating-1500)/factor, ($glicko->RD)/factor, $glicko->volatility, $opponents);
            $p->calculateNewRanking();
        }
    }
}

//A class that models a player. Used to calculate the new ranking
class Player
{
    public $mu;    //the rating
    public $phi;   //rating deviation
    public $sigma; //volatility
    public $v;     //Estimated variance based on how the player played against his opponents
    public $opponents; //Array of objects of the Opponent class
    
    function __construct($mu, $phi, $sigma, $opponents)
    {
        $this->phi=$phi;
        $this->mu=$mu;
        $this->sigma=$sigma;
        $this->opponents=$opponents;
        $preDelta=$this->calculatePreDelta();
    }
    
    //Calculates the estimated variance
    private function calculateV()
    {
        $result=0;
        foreach($this->opponents as $opponent)
        {
            
            $g2=pow($this->functionG($opponent->phi),2);
            
            $E=$this->expectation($opponent);
            $result+=$g2*$E*(1-$E);
        }
        
        $this->v = (1/$result);
    }
    
    //Calculates the expected outcome of a match played against the opponent used as input
    private function expectation($opponent)
    {
        $phi_j=$opponent->phi;
        $mu_j=$opponent->mu;
        
        return (1/(1.0+exp(-Player::functionG($phi_j)*($this->mu-$mu_j))));
    }
    
    //
    private function functionF($x,$a)
    {
        $v=$this->v;
        $ex=exp($x);
        $D2=pow($this->calculateDelta($v),2);
        
        $topterm1=$ex*($D2-pow($this->phi,2)-$v-$ex);
        $botterm1=2*pow(pow($this->phi,2)+$v+$ex,2);
        
        $topterm2=$x-$a;
        $botterm2=pow(TAU,2);
        
        return ($topterm1/$botterm1-$topterm2/$botterm2);
        
    }
    
    private function functionG($x)
    {
        return (1/sqrt(1+3*pow(($x/pi()),2)));
    }
    
    
    private function calculatePreDelta()
    {
        $result=0;
        foreach($this->opponents as $opponent)
        {
            $g=Player::functionG($opponent->phi);
            $E=Player::expectation($opponent);
            $result+=$g*($opponent->s-$E);
        }
        return $result;
    }
    
    private function calculateDelta()
    {
        return $this->calculatePreDelta()*($this->v);
    }
    
    public function calculateNewRanking()
    {
    
        if (!empty($this->opponents))
        {
            
            $this->calculateV();
            $phistar=sqrt(pow($this->phi,2)+pow($this->determineVolatility(),2));
            
            $this->phi=1/(sqrt(1/pow($phistar,2)+1/($this->v)));
            
            $this->mu=$this->mu+pow(($this->phi),2)*($this->calculatePreDelta());
        }
        else
        {
            $phistar=sqrt(pow($this->phi,2)+pow($this->sigma,2));
            $this->phi=$phistar;
        }
    }
    
    //Calculates teh new volatility 
    public function determineVolatility()
    {
        $v=$this->v;
        $a=log(pow($this->sigma,2));
        
        $A=$a;
        $B;
        
        $epsilon=0.000001; //The convergence tolerance
        
        $D2=pow($this->calculateDelta(),2); //Delta^2
        
        
        if ($D2>(pow($this->phi,2)+$v))
            $B=log($D2-pow($this->phi,2)-$v);
        else
        {
            $k=1;
            while($this->functionF($a-$k*TAU,$a)<0)
                {
                    $k++;
                }
            $B=$a-$k*TAU;
        }
        
        
        $f_A=$this->functionF($A,$a);
        $f_B=$this->functionF($B,$a);
        
        //Iterate until we have converged enough
        while(abs($B-$A)>$epsilon)
        {
            $C=$A+($A-$B)*$f_A/($f_B-$f_A);
            $f_C=$this->functionF($C,$a);
            if ($f_B*$f_C<0)
            {
                $A=$B;
                $f_A=$f_B;
            }
            else
            {
                $f_A=$f_A/2;
            }
            $B=$C;
            $f_B=$f_C;
            
           
        }
        
        //return the result
        return exp($A/2);
    }
}

//A class that models an opponent and his ranking data.
class Opponent
{
    public $mu;
    public $phi;
    public $s;
    
    function __construct($mu, $phi, $s)
    {
        $this->phi=$phi;
        $this->mu=$mu;
        $this->s=$s;
    }
}

?>
