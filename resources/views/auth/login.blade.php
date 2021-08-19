<form action="" method="POST" >
    @csrf
    <input type="username" name="email" placeholder="username" value="{{old('email')}}">
    <br>
    <input type="password" name="password" placeholder="password">
    <br>
    <button type="submit">Login</button>
</form>