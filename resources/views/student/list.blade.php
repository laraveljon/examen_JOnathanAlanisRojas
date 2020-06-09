@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-11">
                <h2>Examen Jonathan Alanis Rojas</h2>
        </div>
        <div class="col-lg-1">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addModal">Agregar</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered" id="studentTable">
 <thead>
 <tr>
 <th>id</th>
 <th>Nombre</th>
 <th>Apellido</th>
 <th>Email</th>
 <th>Dirección</th>
 <th width="280px">Action</th>
 </tr>
 </thead>
 <tbody>
        @foreach ($students as $student)
            <tr id="{{ $student->id }}">
                <td>{{ $student->id }}</td>
                <td>{{ $student->nombre }}</td>
                <td>{{ $student->apellido }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->direccion }}</td>
                <td>
      <a data-id="{{ $student->id }}" class="btn btn-primary btnEdit">Editar</a>
      <a data-id="{{ $student->id }}" class="btn btn-danger btnDelete">Eliminar</button>
                </td>
            </tr>
        @endforeach
 </tbody>
    </table>
    {{$students->links()}}


<!-- Add Student Modal -->
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar un nuevo estudiante</h4>
      </div>
   <div class="modal-body">
 <form id="addStudent" name="addStudent" action="{{ route('student.store') }}" method="post">
 @csrf
 <div class="form-group">
 <label for="txtFirstnombre">Nombre:</label>
 <input type="text" class="form-control" id="txtFirstnombre" placeholder="Enter First Name" name="txtFirstnombre">
 </div>
 <div class="form-group">
 <label for="txtLastapellido">Apellido:</label>
 <input type="text" class="form-control" id="txtLastapellido" placeholder="Apellido" name="txtLastapellido">
 </div>
 <div class="form-group">
    <label for="txtemail">Email:</label>
    <input type="text" class="form-control" id="txtemail" placeholder="Email" name="txtemail">
</div>
 <div class="form-group">
 <label for="txtdireccion">Direccion:</label>
 <textarea class="form-control" id="txtdireccion" name="txtdireccion" rows="10" placeholder="direccion"></textarea>
 </div>
 <button type="submit" class="btn btn-primary">Enviar</button>
 </form>
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Update Student Modal -->
<div id="updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Student</h4>
      </div>
   <div class="modal-body">
 <form id="updateStudent" name="updateStudent" action="{{ route('student.update') }}" method="post">
 <input type="hidden" name="hdnStudentId" id="hdnStudentId"/>
 @csrf
 <div class="form-group">
 <label for="txtFirstnombre">Nombre:</label>
 <input type="text" class="form-control" id="txtFirstnombre" placeholder="Enter First Name" name="txtFirstnombre">
 </div>
 <div class="form-group">
 <label for="txtLastapellido">Apelllido:</label>
 <input type="text" class="form-control" id="txtLastapellido" placeholder="Enter Last Name" name="txtLastapellido">
 </div>
 <div class="form-group">
    <label for="txtemail">Email:</label>
    <input type="text" class="form-control" id="txtemail" placeholder="Email" name="txtemail">
</div>
 <div class="form-group">
 <label for="txtdireccion">Direccion:</label>
 <textarea class="form-control" id="txtdireccion" name="txtdireccion" rows="10" placeholder="Direccion"></textarea>
 </div>
 <button type="submit" class="btn btn-primary">Enviar</button>
 </form>
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
 //Add the Student
 $("#addStudent").validate({
 rules: {
 txtFirstnombre: "required",
 txtLastapellido: "required",
 txtemail:"required",
 txtdireccion: "required"
 },
 messages: {
 },

 submitHandler: function(form) {
   var form_action = $("#addStudent").attr("action");
   $.ajax({
   data: $('#addStudent').serialize(),
   url: form_action,
   type: "POST",
   dataType: 'json',
   success: function (data) {
   var student = '<tr id="'+data.id+'">';
   student += '<td>' + data.id + '</td>';
   student += '<td>' + data.nombre + '</td>';
   student += '<td>' + data.apellido + '</td>';
   student += '<td>' + data.email + '</td>';
   student += '<td>' + data.direccion + '</td>';
   student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
   student += '</tr>';
   $('#studentTable tbody').prepend(student);
   $('#addStudent')[0].reset();
   $('#addModal').modal('hide');
   },
   error: function (data) {
   }
   });
 }
 });


    //When click edit student
    $('body').on('click', '.btnEdit', function () {
      var student_id = $(this).attr('data-id');
      $.get('student/' + student_id +'/edit', function (data) {
          $('#updateModal').modal('show');
          $('#updateStudent #hdnStudentId').val(data.id);
          $('#updateStudent #txtFirstnombre').val(data.nombre);
          $('#updateStudent #txtLastapellido').val(data.apellido);
          $('#updateStudent #txtemail').val(data.email);
          $('#updateStudent #txtdireccion').val(data.direccion);
      })
   });
    // Update the student
 $("#updateStudent").validate({
 rules: {
 txtFirstnombre: "required",
 txtLastapellido: "required",
 txtemail:"required",
 txtdireccion: "required"

 },
 messages: {
 },

 submitHandler: function(form) {
   var form_action = $("#updateStudent").attr("action");
   $.ajax({
   data: $('#updateStudent').serialize(),
   url: form_action,
   type: "POST",
   dataType: 'json',
   success: function (data) {
   var student = '<td>' + data.id + '</td>';
   student += '<td>' + data.nombre + '</td>';
   student += '<td>' + data.apellido + '</td>';
   student += '<td>' + data.email + '</td>';
   student += '<td>' + data.direccion + '</td>';
   student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
   $('#studentTable tbody #'+ data.id).html(student);
   $('#updateStudent')[0].reset();
   $('#updateModal').modal('hide');
   },
   error: function (data) {
   }
   });
 }
 });

   //delete student
 $('body').on('click', '.btnDelete', function () {
      var student_id = $(this).attr('data-id');
      $.get('student/' + student_id +'/delete', function (data) {
          $('#studentTable tbody #'+ student_id).remove();
      })
   });

});
</script>
@endsection
