<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>{{$title}}</h2>

<table>
  <tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Date Hired</th>
    <th>Age</th>
    <th>Email</th>
  </tr>
  @foreach ($drivers as $driver)
    <tr>
        <td>{{$driver->id}}</td>
        <td>{{$driver->firstName}}</td>
        <td>{{$driver->lastName}}</td>
        <td>{{$driver->hireDate}}</td>
        <td>{{$driver->age}}</td>
        <td>{{$driver->email}}</td>
    </tr>     
  @endforeach
</table>

</body>
</html>