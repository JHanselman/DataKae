<?php

    define('factor', 400/log(10));
class RankingCalculator
{
    const TAU=0.5;
    
    public function Rank()
    {
        $criteria=new CDbCriteria(); 
        $criteria->condition = "\"Ranked\"=TRUE";
        $players=User::model()->findAll($criteria);
        $bla=array();
        
        $players;
        
        foreach($players as $player)
        {
            //$user
            $playedMatches = $player->matchData;
            $opponents=array();
            
            
            
            
            foreach($playedMatches as $playerRecord)
            {
                
                $match=Match::model()->findByPk($playerRecord->matchId);
                $PlayersSets=$match->matchData;
                foreach($PlayersSets as $goobie)
                {
                    if ($goobie->userId!=$playerRecord->userId)
                    {
                        $OppGlicko=GlickoData::model()->findByAttributes(array('userId' => $goobie->userId, 'matchType' => '1v1'));
                        
                        file_put_contents('E:/wamp/www/logo.txt', $p, FILE_APPEND | LOCK_EX);
                        
                        $score = ($playerRecord->score>$goobie->score) ? 1 : ($playerRecord->score==$goobie->score ? 0.5 : 0);  
                        $opponents[]=new Opponent(($OppGlicko->rating-1500)/factor,($OppGlicko->RD)/factor, $score);
                    }
                }
            }
            
            $glicko= $player->bla;
            
            $p = new Player(($glicko->rating-1500)/factor, ($glicko->RD)/factor, $glicko->volatility, $opponents);
            $p->calculateNewRanking();
            //return $p->mu;
            //return $p->phi;
        }
        /*
        $player=new Player();
        $player->mu=0;
        $player->phi=200/173.7178;
        $player->sigma=0.06;
        
        $opp1=new Opponent;
        $opp2=new Opponent;
        $opp3=new Opponent;
        
        $opp1->mu=(1400-1500)/173.7178;
        $opp2->mu=(1550-1500)/173.7178;
        $opp3->mu=(1700-1500)/173.7178;
        
        $opp1->phi=30/173.7178;
        $opp2->phi=100/173.7178;
        $opp3->phi=300/173.7178;
        
        $opp1->s=1;
        $opp2->s=0;
        $opp3->s=0;
        
        $player->opponents=array($opp1,$opp2,$opp3);
        //return $opp3->phi;
        $v=$player->calculateV();
        
        return serialize($bla);
        return $player->determineVolatility($v);
        */
    }
}

class Player
{
    public $mu;
    public $phi;
    public $sigma;
    public $v;

    public $opponents;
    
    function __construct($mu, $phi, $sigma, $opponents)
    {
        $this->phi=$phi;
        $this->mu=$mu;
        $this->sigma=$sigma;
        $this->opponents=$opponents;
    }
    
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
    
    private function expectation($opponent)
    {
        $phi_j=$opponent->phi;
        $mu_j=$opponent->mu;
        
        return (1/(1.0+exp(-Player::functionG($phi_j)*($this->mu-$mu_j))));
    }
    
    private function functionF($x,$a)
    {
        $v=$this->v;
        $ex=exp($x);
        $D2=pow($this->calculateDelta($v),2);
        
        $topterm1=$ex*($D2-pow($this->phi,2)-$v-$ex);
        $botterm1=2*pow(pow($this->phi,2)+$v+$ex,2);
        
        $topterm2=$x-$a;
        $botterm2=pow(RankingCalculator::TAU,2);
        
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
            
            file_put_contents('E:/wamp/www/logo.txt', $this->mu." ", FILE_APPEND | LOCK_EX);
            file_put_contents('E:/wamp/www/logo.txt', $this->phi." ", FILE_APPEND | LOCK_EX);
            
        }
        else
        {
            $phistar=sqrt(pow($this->phi,2)+pow($this->sigma,2));
            $this->phi=$phistar;
        }
    }
    
    
    public function determineVolatility()
    {
        $v=$this->v;
        $a=log(pow($this->sigma,2));
        $A=$a;
        $B;
        $epsilon=0.000001;
        
        $D2=pow($this->calculateDelta(),2);
        
        
        if ($D2>(pow($this->phi,2)+$v))
            $B=log($D2-pow($this->phi,2)-$v);
        else
        {
            $k=1;
            while($this->functionF($a-$k*(RankingCalculator::TAU),$a)<0)
                {
                    $k++;
                }
            $B=$a-$k*(RankingCalculator::TAU);
        }
        
        
        $f_A=$this->functionF($A,$a);
        $f_B=$this->functionF($B,$a);
        
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
        return exp($A/2);
    }
}


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
