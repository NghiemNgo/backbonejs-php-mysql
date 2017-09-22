<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CRUD BackboneJS PHP MySQL</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    
    <style>
        
    .alert.fixed {
        position: fixed;
        top: 20px;
        left: 25%;
        width: 50%;
        margin-bottom: 0;
        box-shadow: 0px 0px 10px #454545;
    }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Modal Confirm
                </div>
                <div class="modal-body">
                    <div class="content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a href="#" id="delete" class="btn btn-success success">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        
        <div class="page-header">
            <h1>MY CRUD</h1>
        </div>
        <div id="message"></div>
        <div class="panel panel-default">
            <div class="panel-body" id="primary-content">
                <!-- this is content -->
            </div>
        </div>
        <button style="margin:10px 0;" class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-desktop"></i> Show Output JSON</button>
        <div class="collapse" id="collapseExample">
            <code id="output" style="display:block;white-space:pre-wrap;"></code>
        </div>
    </div>
    <script type="text/jst" id="formTemplate">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-danger fade in" style="display:none;"></div>
                <form>
                    <h2><%= name %></h2>
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" name="name" value="<%= name %>" />
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" class="form-control" name="email" value="<%= email %>" />
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" class="form-control" name="phone" value="<%= phone %>" />
                    </div>
                    <div class="form-group">
                        <label>Address:</label>
                        <textarea class="form-control" rows="5" name="address"><%= address %></textarea>
                    </div>
                    <div class="form-group">
                        <label>Active:</label>
                        <% if(_.isEmpty(active) == false && active == 1) { %>
                            <input type="checkbox" name="active" value="1" checked>
                        <% } else { %>
                            <input type="checkbox" name="active" value="0">
                        <% } %>
                    </div>
                    <button class="save btn btn-large btn-info" type="submit">Save</button>
                    <a href="#crud/index" class="btn btn-large btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </script>

    <!-- the index container -->
    <script type="text/template" id="indexTemplate">

        <a style="margin:10px 0px;" class="btn btn-large btn-info" href="#crud/new"><i class="fa fa-plus"></i> Create New Data</a>

        <div id="collapseExample2">
        <% if (_.isEmpty(cruds)){ %>
        <div class="alert alert-warning">
            <p>There are currently no cruds. Try creating some.</p>
        </div>
        <% } %>

        <table id="list-cruds" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Active</th>
                    <th width="140">Action</th>
                </tr>
            </thead>
            <tbody>
                <% var idx = 1 %>
                <% _.each(cruds, function (crud) { %>
                <tr>
                    <td><%= idx++ %></td>
                    <td><%= crud.name %></td>
                    <td><%= crud.email %></td>
                    <td><%= crud.phone %></td>
                    <td><%= crud.address %></td>
                    <% if (crud.active == 0) {%>
                        <td>Disable</td>
                    <% } else { %>
                        <td>Active</td>
                    <% } %>
                    <td class="text-center">
                        <a class="btn btn-xs btn-info" href="#crud/<%= crud.id %>/edit"><i class="fa fa-pencil"></i> Edit</a>
                        <a id="deleteButton" class="btn btn-xs btn-danger item-destroy" data-id="<%= crud.id %>"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <% }); %>
            </tbody>
        </table>
        <a style="margin:10px 0px;" class="btn btn-large btn-info" href="#crud/index"> All</a>
        <a style="margin:10px 0px;" class="btn btn-large btn-info" href="#crud/active"> Active</a>
        <a style="margin:10px 0px;" class="btn btn-large btn-info" href="#crud/disable"> Disable</a>
        </div>
        
    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/backbone/underscore-min.js"></script>
    <script src="assets/backbone/backbone-min.js"></script>
    <script src="assets/backbone/backbone.localStorage.js"></script>
    <script src="http://cdn.pubnub.com/pubnub.min.js"></script>
    <script src="bower_components/pubnub-backbone/backbone-pubnub.min.js"></script>
    <script>
    var pubnub = PUBNUB.init({
        subscribe_key: 'sub-c-4c7f1748-ced1-11e2-a5be-02ee2ddab7fe',
        publish_key: 'pub-c-6dd9f234-e11e-4345-92c4-f723de52df70',
    });
    </script>
    <script src="routers.js"></script>
    <script src="models.js"></script>
    <script src="views/view.js"></script>
    <script src="views/add.js"></script>
    <script src="views/edit.js"></script>
    <script src="helpers.js"></script>
    <script src="views/notification.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script>
    var app = new APP.crudRouter();
    </script>
  </body>
</html>