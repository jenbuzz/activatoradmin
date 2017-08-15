<ul class="pagination">
  <li class="page-item<% if (currentPage == 1) { %> disabled<% } %>"><a href="#" class="page-link first">First</a></li>
  <li class="page-item<% if (currentPage == 1) { %> disabled<% } %>"><a href="#" class="page-link prev" rel="prev">Previous</a></li>
  <% _.each (pageSet, function (p) { %>
    <% if (currentPage == p) { %>
      <li class="page-item active"><a href="#" class="page-link"><%= p %></a></li>
    <% } else { %>
      <li class="page-item"><a href="#" class="page-link page"><%= p %></a></li>
    <% } %>
  <% }); %>
  <li class="page-item<% if (lastPage == currentPage || lastPage == 0) { %> disabled<% } %>"><a href="#" class="page-link next" rel="next">Next</a></li>
  <li class="page-item<% if (lastPage == currentPage || lastPage == 0) { %> disabled<% } %>"><a href="#" class="page-link last">Last</a></li>
</ul>
