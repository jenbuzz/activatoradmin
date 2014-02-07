<label>
  <input id="toggle-activate" type="checkbox" <% if(isactive==1) { %>checked="checked" <% } %>title="<% if(isactive==1) { %>de<% } %>activate" />
  <%=name%>
</label>
<img class="img-thumbnail" src="<% if(image) { %><%=image%><% } else { %>images/default.jpg<% } %>" />
