<form action="{{route('user.payment')}}" method="post" name="userForm" id="userForm">
  @csrf
<table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="row"><input type="text" name="name" id="name"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <tr>
      <th scope="col">Email</th>
      <th scope="row"><input type="text" name="email" id="email"></th>
    </tr>
    <tr>
      <th scope="col">Password</th>
      <th scope="row"><input type="password" name="password" id="password"></th>
    </tr>
    <tr>
      <th scope="col"><input type="submit" name="submit" id="submit"></th>
    </tr>
  </tbody>
</table>
</form>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>