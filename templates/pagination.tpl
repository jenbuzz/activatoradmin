<ul class="pagination">
  <li<% if (currentPage == 1) { %> class="disabled"<% } %>><a href="#" class="first">First</a></li>
  <li<% if (currentPage == 1) { %> class="disabled"<% } %>><a href="#" class="prev" rel="prev">Previous</a></li>
  <% _.each (pageSet, function (p) { %>
    <% if (currentPage == p) { %>
      <li class="active"><a href="#"><%= p %></a></li>
    <% } else { %>
      <li><a href="#" class="page"><%= p %></a></li>
    <% } %>
  <% }); %>
  <li<% if (lastPage == currentPage || lastPage == 0) { %> class="disabled"<% } %>><a href="#" class="next" rel="next">Next</a></li>
  <li<% if (lastPage == currentPage || lastPage == 0) { %> class="disabled"<% } %>><a href="#" class="last">Last</a></li>
</ul>
