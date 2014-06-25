<div class="itemContainer">
  <div>
    <input id="toggle-activate-<%=id%>" class="toggle-activate" type="checkbox" <%= isactive==1 ? "checked" : "" %> title="<% if(isactive==1) { %>de<% } %>activate" />
    <label for="toggle-activate-<%=id%>"><%=name%></label>
    <img class="img-thumbnail" src="<% if(image) { %><%=image%><% } else { %>images/default.jpg<% } %>" />
  </div>

  <% if(show_info || show_delete) { %>
  <div>
    <% if(show_info) { %>
    <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#itemInfo-<%=id%>"><span class="fa fa-info"></span></button>
    <% } %>
    <% if(show_info && show_delete) { %>
    <br /><br />
    <% } %>
    <% if(show_delete) { %>
    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#itemDelete-<%=id%>"><span class="fa fa-times"></span></button>
    <% } %>
  </div>
  <% } %>
</div>

<% if(show_info) { %>
<div class="modal fade" id="itemInfo-<%=id%>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="itemInfoLabel-<%=id%>"><%=name%></h4>
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td><strong>ID</strong>:</td>
            <td><%=id%></td>
          </tr>
          <tr>
            <td><strong>Name</strong>:</td>
            <td><%=name%></td>
          </tr>
          <tr>
            <td><strong>Active</strong>:</td>
            <td><%=isactive%></td>
          </tr>
          <tr>
            <td><strong>Image</strong>:</td>
            <td><%=image%></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<% } %>

<% if(show_delete) { %>
<div class="modal fade" id="itemDelete-<%=id%>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><%=name%></h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <strong><%=name%></strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="itemDeleteConfirm">Delete</button>
      </div>
    </div>
  </div>
</div>
<% } %>
