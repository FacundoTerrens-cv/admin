<?php
session_start();
if(!isset($_SESSION['user'])){
  header('location: login.php');
}
require_once('conection.php');
$empleado = $_SESSION['user'];
$sql = "SELECT id, title, start, end, color FROM events WHERE empleado = '$empleado' AND vacations = 1";
$events = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>Dashboard - SB Admin</title>
      <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
      <link href="css/styles.css" rel="stylesheet" />
      <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
      <link href='css/fullcalendar.css' rel='stylesheet' />
      <style>
         body {
         padding-top: 70px;
         }
         #calendar {
         max-width: 800px;
         }
         .col-centered{
         float: none;
         margin: 0 auto;
         }
      </style>
   </head>
   <body class="sb-nav-fixed">
      <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
         <!-- Navbar Brand-->
         <a class="navbar-brand ps-3" href="index.html">Admin DashBoard</a>
         <!-- Sidebar Toggle-->
         <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
         <!-- Navbar Search-->
         <!--
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            --> 
         <!-- Navbar-->
      </nav>
      <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
         <div class="sb-sidenav-menu">
            <div class="nav">
               <div class="sb-sidenav-menu-heading">Core</div>
               <a class="nav-link" href="vacaciones_doc.php">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Vacations
               </a>
               <a class="nav-link" href="pedidos_doc.php">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Pedidos
               </a>
               <a class="nav-link" href="logout.php">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  LogOut
               </a>
            </div>
      </nav>
      </div>
      <div id="layoutSidenav_content">
         <main>
            <div class="container-fluid px-4">
               <h1 class="mt-4">Vacations</h1>
               <?php
                  $sql = "SELECT * FROM events WHERE empleado = '$empleado' AND vacations = 1;";
                  $consulta = mysqli_query($conn, $sql);
                  ?>
               <div class="card mb-4">
                  <div class="card-header">
                     <i class="fas fa-table me-1"></i>
                     Vacations Table
                  </div>
                  <div class="card-body">
                     <table id="datatablesSimple">
                        <thead>
                           <tr>
                              <th>Title</th>
                              <th>Fecha Inicio</th>
                              <th>Fecha Final</th>
                              <th>Empleado</th>
                              <th>Delete</th>
                              <th>Edit</th>
                           </tr>
                        </thead>
                        <tfoot>
                           <tr>
                              <th>Title</th>
                              <th>Fecha Inicio</th>
                              <th>Fecha Final</th>
                              <th>Empleado</th>
                              <th>Delete</th>
                              <th>Edit</th>
                           </tr>
                        </tfoot>
                        <tbody>
                           <?php 
                              while($emp = mysqli_fetch_array($consulta)){ ?>
                           <tr>
                              <td><?php echo $emp['title']?></td>
                              <td><?php echo $emp['start']?></td>
                              <td><?php echo $emp['end']?></td>
                              <td><?php echo $emp['empleado']?></td>
                              <td>
                                 <form action="" method="post">
                                    <a class="btn btn-danger" style="background-color: red" type="submit" name="btn" value="eliminar" href="delete_vacaciones.php?id=<?php echo $emp['id']?>">Fjerne</a>
                              </td>
                              </form>
                              </td>
                              <td>
                                 <form action="" method="post">
                                    <a class="btn btn-success" style="background-color: green" type="submit" name="btn" value="eliminar" href="edit_pedidos_front_doc.php?id=<?php echo $emp['id']?>">Redigere</a>
                              </td>
                              </form>
                           </tr>
                           <?php }?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card mb-4">
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-12 text-center">
                           <h1>Pedidos</h1>
                           <div id="calendar" class="col-centered">
                           </div>
                        </div>
                     </div>
                     <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <form class="form-horizontal" method="POST" action="addVacations.php">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Agregar Evento</h4>
                                 </div>
                                 <div class="modal-body">
                                    <div class="form-group">
                                       <label for="title" class="col-sm-2 control-label">Titulo</label>
                                       <div class="col-sm-10">
                                          <input type="text" name="title" class="form-control" id="title" placeholder="Vacations" value="Vacations">
                                       </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                       <label for="color" class="col-sm-2 control-label">Color</label>
                                       <div class="col-sm-10">
                                          <select name="color" class="form-control" id="color">
                                             <option value="">Seleccionar</option>
                                             <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
                                             <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                             <option style="color:#008000;" value="#008000">&#9724; Verde</option>
                                             <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                             <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                             <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                             <option style="color:#000;" value="#000">&#9724; Negro</option>
                                          </select>
                                       </div>
                                    </div>
                                    <!--  <div class="form-group">
                                       <label for="color" class="col-sm-2 control-label">horario</label>
                                       <div class="col-sm-10">
                                         <select name="empleado" class="form-control" id="empleado">
                                       				  <option value="">Seleccionar</option>
                                       	  <option style="color:#000;" value="09:00:00-10:00:00">09:00:00 - 10:00:00</option>
                                       	</select>
                                       </div>
                                        </div> -->
                                    <div class="form-group" style="display: none;">
                                       <label for="color" class="col-sm-2 control-label">Empleado</label>
                                       <div class="col-sm-10">
                                          <select name="servicio" class="form-control" id="servicio">
                                             <option value="">Seleccionar</option>
                                             <option style="color:#000;" value="Corte de Pelo">Corte de pelo</option>
                                             <option style="color:#000;" value="Color">Color</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
                                       <div class="col-sm-10">
                                          <input type="text" name="start" class="form-control" id="start" readonly>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="end" class="col-sm-2 control-label">Fecha Final</label>
                                       <div class="col-sm-10">
                                          <input type="text" name="end" class="form-control" id="end" readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                     <!-- Modal -->
                     <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <form class="form-horizontal" method="POST" action="editEventTitle.php">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modificar Evento</h4>
                                 </div>
                                 <div class="modal-body">
                                    <div class="form-group">
                                       <label for="title" class="col-sm-2 control-label">Titulo</label>
                                       <div class="col-sm-10">
                                          <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="color" class="col-sm-2 control-label">Color</label>
                                       <div class="col-sm-10">
                                          <select name="color" class="form-control" id="color">
                                             <option value="">Seleccionar</option>
                                             <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
                                             <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                             <option style="color:#008000;" value="#008000">&#9724; Verde</option>
                                             <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                             <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                             <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                             <option style="color:#000;" value="#000">&#9724; Negro</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-sm-offset-2 col-sm-10">
                                          <div class="checkbox">
                                             <label class="text-danger"><input type="checkbox"  name="delete"> Eliminar Evento</label>
                                          </div>
                                       </div>
                                    </div>
                                    <input type="hidden" name="id" class="form-control" id="id">
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
         </main>
         <footer class="py-4 bg-light mt-auto">
         <div class="container-fluid px-4">
         <div class="d-flex align-items-center justify-content-between small">
         <div class="text-muted">Copyright &copy; Your Website 2022</div>
         <div>
         <a href="#">Privacy Policy</a>
         &middot;
         <a href="#">Terms &amp; Conditions</a>
         </div>
         </div>
         </div>
         </footer>
         </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
      <script src="js/scripts.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
      <script src="assets/demo/chart-area-demo.js"></script>
      <script src="assets/demo/chart-bar-demo.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
      <script src="js/datatables-simple-demo.js"></script>
      <script src="js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
      <!-- FullCalendar -->
      <script src='js/moment.min.js'></script>
      <script src='js/fullcalendar/fullcalendar.min.js'></script>
      <script src='js/fullcalendar/fullcalendar.js'></script>
      <script src='js/fullcalendar/locale/es.js'></script>
      <script>


$(document).ready(function() {
      var date = new Date();
      var primeraHora = '08:00:00';
      var finalHora = '19:00:00';
      var yyyy = date.getFullYear().toString();
      var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
      var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();  
    $('#calendar').fullCalendar({
        header: {
             language: 'es',
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay',
        },
        defaultDate: yyyy+"-"+mm+"-"+dd,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        selectOverlap: false, //hace que donde hay evento no se pueda crear otro
        minTime: '08:00:00',
        maxTime: '19:00:00',
        Boolean, default: true,
        selectAllow: false,
        hiddenDays: [ 0 ],

        select: function(start, end) {
            $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
            $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
            $('#ModalAdd').modal('show');
        },
        eventRender: function(event, element) {
            element.bind('dblclick', function() {
                $('#ModalEdit #id').val(event.id);
                $('#ModalEdit #title').val(event.title);
                $('#ModalEdit #color').val(event.color);
                $('#ModalEdit #empleado').val(event.empleado);
                $('#ModalEdit').modal('show');
            });
        },
        eventDrop: function(event, delta, revertFunc) { // si changement de position
            edit(event);
        },
        eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur
            edit(event);
        },
        events: [
        <?php while($event = mysqli_fetch_array($events)){
            $start = explode(" ", $event['start']);
            $end = explode(" ", $event['end']);
            if($start[1] == '08:00:00'){
                $start = $start[0];
            }else{
                $start = $event['start'];
            }
            if($end[1] == '18:00:00'){
                $end = $end[0];
            }else{
                $end = $event['end'];
            }
        ?>
            {
                id: '<?php echo $event['id']; ?>',
                title: '<?php echo $event['title']; ?>',
                start: '<?php echo $start; ?>',
                end: '<?php echo $end; ?>',
                color: '<?php echo $event['color']; ?>'
            },
        <?php } ?>
        ]
    });
    function edit(event){
        start = event.start.format('YYYY-MM-DD HH:mm:ss');
        if(event.end){
            end = event.end.format('YYYY-MM-DD HH:mm:ss');
        }else{
            end = start;
        }
        id =  event.id;
        Event = [];
        Event[0] = id;
        Event[1] = start;
        Event[2] = end;
        $.ajax({
         url: 'editEventDate.php',
         type: "POST",
         data: {Event:Event},
         success: function(rep) {
                if(rep == 'OK'){
                    alert('Evento se ha guardado correctamente');
                }else{
                    alert('No se pudo guardar. Inténtalo de nuevo.'); 
                }
            }
        });
    }
});
</script>
    </body>
</html>
