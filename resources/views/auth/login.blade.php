<form method="POST" action="{{ url('/login') }}">
    @csrf
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label><input type="checkbox" name="remember"> Remember Me</label>
    </div>
    <button type="submit">Log In</button>
</form>
