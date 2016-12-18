<?php
echo('
<script src="../../wp-content/themes/sudocity/d3/d3.v3.min.js"></script>
<style>

.link {
  fill: none;
  stroke: #999999;
  stroke-width: 1px;
}

circle {
  fill: #e1e0d3;
  stroke: #999999;
  stroke-width: 1px;
  opacity: 0.8;
}

text {
  font: 10px sans-serif;
  pointer-events: none;
  z-index:100;
  opacity: 0.8;
}

</style>
<script>

// get the data
d3.json("../../wp-content/themes/sudocity/d3/notedata.php", function(error, links) {

var nodes = {};
var optog = 0;

// Compute the distinct nodes from the links.
links.forEach(function(link) {
    link.source = nodes[link.source] || 
        (nodes[link.source] = {name: link.source});
    link.target = nodes[link.target] || 
        (nodes[link.target] = {name: link.target});
    link.value = +link.value;
});

var linkedByIndex = {};
links.forEach(function(d) {
	linkedByIndex[d.source.index + "," + d.target.index] = 1;
});

var width = 1140,
    height = 300;

var force = d3.layout.force()
    .nodes(d3.values(nodes))
    .links(links)
    .size([width, height])
    .linkDistance(100)
//     .linkStrength(0.5)
    .charge(-180)
    .gravity(0.10)
    .start();

var svg = d3.select(".archive-header").append("svg")
    .attr("width", width)
    .attr("height", height);

  var link = svg.selectAll(".link")
      .data(force.links())
    .enter().append("line")
      .attr("class", "link")
      .style("stroke-width", 1);


var node = svg.selectAll(".node")
    .data(force.nodes())
  .enter().append("g")
    .attr("class", "node")
    .on("mouseover", mouseover)
    .on("mouseout", mouseout)
    .on("click", fade(0.2))
//     .on("drag", fade(0.1))
//     .on("dragend", fade(0.8))
    .call(force.drag);

node.append("circle")
    .attr("r", function(d) {return force.links().filter(function(p)
{return p.source == d}).length});

node.append("text")
    .attr("dx", ".5em")
    .attr("dy", ".35em")
    .style("font-size",function(d) {
      	
      	var ts = force.links().filter(
      		function(p) {
      			return p.source == d 
      		}).length;
      		
      	if (ts > 5) { return "16px"; } else { return ts*3+"px"; }
      		
		})
    .text(function(d) { return d.name; });


  force.on("tick", function() {
    link.attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });

    node
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
      
  });
  
function isConnected(a, b) {
	return linkedByIndex[a.index + "," + b.index] || linkedByIndex[b.index + "," + a.index] || a.index == b.index;
}

function mouseover() {
  d3.select(this).select("circle").transition()
      .duration(350)
      .attr("r", 16);
    d3.select(this).select("text").transition()
      .duration(350)
      .attr("dx", "1em")
	  .attr("dy", ".35em")
	  .style("opacity",1)
      .style("font-size","18px");
}

function mouseout() {
  d3.select(this).select("circle").transition()
      .duration(350)
      .attr("r", function(d) {return force.links().filter(function(p)
{return p.source == d}).length});
    d3.select(this).select("text").transition()
      .duration(750)
      .attr("dx", ".5em")
	  .attr("dy", ".35em")
      .style("font-size",function(d) {
      	var ts = force.links().filter(
      		function(p) {
      			return p.source == d 
      		}).length;
      	if (ts > 5) { return "16px"; } else { return ts*3+"px"; }
      });
	}

    function fade(opacity) {
        return function(d) {
//             node.transition()
//      				.duration(75).style("stroke-opacity", function(o) {
//                 thisOpacity = isConnected(d, o) ? 1 : opacity;
//                 this.setAttribute("fill-opacity", thisOpacity);
//                 return thisOpacity;
//             });

            link.transition()
				  .duration(75).style("stroke-opacity", function(o) {
                return o.source === d || o.target === d ? 1 : opacity;
            });
        };
    }

});



</script>
');