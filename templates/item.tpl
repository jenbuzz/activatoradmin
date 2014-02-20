<div class="itemContainer">
  <div>
   <label>
      <input id="toggle-activate" type="checkbox" <% if(isactive==1) { %>checked="checked" <% } %>title="<% if(isactive==1) { %>de<% } %>activate" />
      <%=name%>
    </label>
    <img class="img-thumbnail" src="<% if(image) { %><%=image%><% } else { %>images/default.jpg<% } %>" />
  </div>

  <div>
    <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#itemInfo-<%=id%>">i</button>
    <br /><br />
    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#itemDelete-<%=id%>">x</button>
  </div>
</div>

<div class="modal fade" id="itemInfo-<%=id%>" tabindex="-1" role="dialog">
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

<div class="modal fade" id="itemDelete-<%=id%>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><%=name%></h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete "<%=name%>"?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="itemDeleteConfirm">Delete</button>
      </div>
    </div>
  </div>
</div>
