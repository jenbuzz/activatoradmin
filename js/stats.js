(function () {
  'use strict';

  var margin = {
    top: 20, 
    right: 20, 
    bottom: 30, 
    left: 40
  };

  var width = 500 - margin.left - margin.right;
  var height = 500 - margin.top - margin.bottom;

  var x = d3.scaleBand().range([0, width]).padding(0.1);
  var y = d3.scaleLinear().range([height, 0]);

  var svg = d3.select('.statsActivated')
      .append('svg')
      .attr('width', width + margin.left + margin.right)
      .attr('height', height + margin.top + margin.bottom)
      .append('g')
      .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

  d3.json('get-stats', function(error, data) {
    if (error) {
      throw error;
    }

    x.domain(data.map(function(d) { return d.name; }));
    y.domain([0, d3.max(data, function(d) { return d.value; })]);

    svg.append('g')
       .attr('class', 'x axis')
       .attr('transform', 'translate(0,' + height + ')')
       .call(d3.axisBottom(x));

    svg.append('g')
       .attr('class', 'y axis')
       .call(d3.axisLeft(y))
       .append('text')
       .attr('transform', 'rotate(-90)')
       .attr('y', 6)
       .attr('dy', '.71em');

    var bar = svg.selectAll('.bar')
       .data(data)
       .enter()
       .append('rect')
       .attr('class', 'bar')
       .attr('x', function(d) { return x(d.name); })
       .attr('width', x.bandwidth())
       .attr('y', height)
       .attr('height', 0);

    bar.append('title')
       .text(function(d) { return d.value + ' items'; })

    bar.transition()
       .duration(750)
       .attr('y', function(d) { return y(d.value); })
       .attr('height', function(d) { return height - y(d.value); });
  });
}());
