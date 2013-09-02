<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<script type="text/javascript" src="../external/raphael.js"></script>
<script type="text/javascript" src="/application/testdrive/assets/807a2310/jquery.js"></script>
    <h1>Tourney bracket </h1>
    <div id="bracket">
        <script type="text/javascript">
        
        var entrants=32;
        
        var matchx=120;
        var matchy=24;
        
        var paddingx=40;
        var paddingy=16;
        
        var rounds=(Math.ceil(Math.log(entrants)/Math.LN2));
        
        //var paper = Raphael("bracket", (rounds+1) *(matchx+paddingx)+paddingx, (Math.pow(2,(rounds)))*(matchy+paddingy)+paddingy); 
        var paper = Raphael("bracket", 700, 700); 
        var paperx = (rounds+1) *(matchx+paddingx)+paddingx
        var papery = (Math.pow(2,(rounds)))*(matchy+paddingy)+paddingy
        //paper.setViewBox(0,0,Math.min(paper.width,800),Math.min(paper.height,800));
        var nodes=new Array();
        
        var leaves=1;
        nodes[0]=new Node(0,null,null,null,0);
        while(leaves<entrants)
        {
            insertNode(0);
        }
        
                seeding();
        
        drawnNodes=new Array();
        drawNode(nodes[0],paperx-matchx-paddingx,papery/2-paddingy,2);
        drawLine(nodes[0]);
        
        
        //Pan and zoom
        paper.setViewBox(0,0,paper.width,paper.height);
        
        var zoomStep = 1.25;
        var zoomLevel = 0;
        var zoomMax = 3;
        var zoomMin = -2; 

        var viewBoxWidth = paper.width;
        var viewBoxHeight = paper.height;
        
        var startX,startY;
        var mousedown = false;
        var dX,dY;
        var oX = 0, oY = 0, oWidth = viewBoxWidth, oHeight = viewBoxHeight;
        var viewBox = paper.setViewBox(oX, oY, viewBoxWidth, viewBoxHeight);
        viewBox.X = oX;
        viewBox.Y = oY;
        
        function Node(id, parent, left, right, children)
        {
            this.id=id;
            this.parent=parent;
            this.left=left;
            this.right=right;
            this.children=children;
            this.name=null;
            
            this.setName=setName;
            
            function setName(name)
            {
                this.name=name;
            };
        }
        
        function insertNode(i)
        {
            if (nodes[i].left==null)
                {
                    nodes[i].left=nodes.length;
                    nodes[i].right=nodes.length+1;
                    nodes[i].children+=2;
                    nodes[nodes.length]=new Node(nodes.length,i,null,null,0);
                    nodes[nodes.length]=new Node(nodes.length,i,null,null,0);
                    leaves+=1;
                }
            else
            {
                    {
                        if(nodes[nodes[i].left].children>nodes[nodes[i].right].children)
                        {
                            insertNode(nodes[i].right);
                            nodes[i].children+=2;
                        }
                        else
                        {
                            insertNode(nodes[i].left);
                            nodes[i].children+=2;
                        }
                    }
            }
            
        }
        
        function seeding()
        {
            for(i=1;i<=entrants;i++)
            {
                nodes[nodes.length-i].setName("Player "+i);
            }
        }
        function drawNode(node,x,y,depth)
        {
            drawnNodes[node.id] = paper.rect(x,y,matchx,matchy).attr({fill: "orange"});
            if (node.name!=null)
            {
                var name=paper.text(x+matchx/2,y+matchy/2,node.name);
                name.attr({"font-size":16});
            }
            drawnNodes[node.id].node.onmouseover = function () {
                drawnNodes[node.id].attr("fill", "red");
            };
            drawnNodes[node.id].node.onmouseout = function () {
                drawnNodes[node.id].attr("fill", "orange");
            };
            if(node.left!=null)
            {
                drawNode(nodes[node.left],x-matchx-paddingx,y-Math.pow(2,(rounds))*(matchy+paddingy)/Math.pow(2,depth),depth+1);
            }
            
            if(node.right!=null)
            {
                drawNode(nodes[node.right],x-matchx-paddingx,y+Math.pow(2,(rounds))*(matchy+paddingy)/Math.pow(2,depth),depth+1);
            }
            
        }
        
        function drawLine(node)
        {
            if (nodes[node.parent]!=null)
            {
                var parentHeight = drawnNodes[node.parent].attr("y");
                var c = paper.path("M"+(drawnNodes[node.id].attr("x")+matchx)+","+(drawnNodes[node.id].attr("y")+matchy/2)+"h"+paddingx/2+"V"+(parentHeight+matchy/2)+"h"+paddingx/2);
                c.attr("stroke-width", "4");
            }
            
            if(node.left!=null)
            {
                drawLine(nodes[node.left]);
            }
            
            if(node.right!=null)
            {
                drawLine(nodes[node.right]);
            }
        }


    /** This is high-level function.
     * It must react to delta being more/less than zero.
     */
    function handle(delta) {
        vBHo = viewBoxHeight;
        vBWo = viewBoxWidth;
        if (delta > 0 && zoomLevel > zoomMin) {
        viewBoxWidth *=(1/zoomStep);
        viewBoxHeight*= (1/zoomStep);
        zoomLevel--;
        }
        else
        {        
            if(delta < 0 && zoomLevel < zoomMax)
            {
            viewBoxWidth *= zoomStep;
            viewBoxHeight *= zoomStep;
            zoomLevel++;
            }
        }
                        
      viewBox.X -= (viewBoxWidth - vBWo) *0.5;
      viewBox.Y -= (viewBoxHeight - vBHo) *0.5;          
      paper.setViewBox(viewBox.X,viewBox.Y,viewBoxWidth,viewBoxHeight);
    }

    /** Event handler for mouse wheel event.
     */
    function wheel(event){
            var delta = 0;
            if (!event) /* For IE. */
                    event = window.event;
            if (event.wheelDelta) { /* IE/Opera. */
                    delta = event.wheelDelta/120;
            } else if (event.detail) { /** Mozilla case. */
                    /** In Mozilla, sign of delta is different than in IE.
                     * Also, delta is multiple of 3.
                     */
                    delta = -event.detail/3;
            }
            /** If delta is nonzero, handle it.
             * Basically, delta is now positive if wheel was scrolled up,
             * and negative, if wheel was scrolled down.
             */
            if (delta)
                    handle(delta);
            /** Prevent default actions caused by mouse wheel.
             * That might be ugly, but we handle scrolls somehow
             * anyway, so don't bother here..
             */
            if (event.preventDefault)
                    event.preventDefault();
        event.returnValue = false;
    }

    /** Initialization code. 
     * If you use your own event management code, change it as required.
     */
    if (window.addEventListener)
            /** DOMMouseScroll is for mozilla. */
            window.addEventListener('DOMMouseScroll', wheel, false);
    /** IE/Opera. */
    window.onmousewheel = document.onmousewheel = wheel;

//Pan
        $("#bracket").mousedown(function(e){
            
            if (paper.getElementByPoint( e.pageX, e.pageY ) != null) {return;}
            mousedown = true;
            startX = e.pageX; 
            startY = e.pageY;    
        });

        $("#bracket").mousemove(function(e){
            if (mousedown == false) {return;}
            dX = startX - e.pageX;
            dY = startY - e.pageY;
            x = viewBoxWidth / paper.width; 
            y = viewBoxHeight / paper.height; 

            dX *= x; 
            dY *= y; 
            
            paper.setViewBox(viewBox.X + dX, viewBox.Y + dY, viewBoxWidth, viewBoxHeight);

        })
            
        $("#bracket").mouseup(function(e){
            if ( mousedown == false ) {return;} 
            viewBox.X += dX; 
            viewBox.Y += dY; 
            mousedown = false; 
            
        });
        
        $("#bracket").mouseout(function(e){
            if ( mousedown == false ) {return;} 
            viewBox.X += dX; 
            viewBox.Y += dY; 
            mousedown = false; 
            
        });
        var elem = document.getElementById("bracket");
        if (elem.requestFullscreen) {
          elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) {
          elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
          elem.webkitRequestFullscreen();
}
        </script>
        
        
    </body>

