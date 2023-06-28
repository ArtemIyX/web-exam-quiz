@extends('layout')
@section('title', 'Dashboard')

@section('content')
<div>

    <div>
        <!-- Show User Details -->
        <h2>User Details</h2>
        <div>
            <a href="{{route('user.sub')}}">Submissions</a>
        </div>
        <div>
            <p>Name: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
        </div>
    </div>
    <div>
        <!-- Button to Show Edit Form -->
        <button id="editButton">Edit</button>
    </div>
    <!-- Edit User Div (Initially Hidden) -->
    <div id="editDiv" style="display: none;">
        <h2>Edit User Details</h2>
        <form id="editForm" action="{{ route('user.update') }}" method="POST">
            @csrf
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Save Changes</button>
        </form>
    </div>

      <!-- Button to Show Passwor Form -->
      <button id="passwordButton">Change Password</button>
      <div id="passwordDiv" style="display: none;">

        <h2>Edit Password</h2>
        <form method="POST" action="{{ route('user.update.password') }}">
            @csrf

            <div>
                <label for="old_password">Old Password</label>
                <input id="old_password" type="password" name="old_password" required>
            </div>

            <div>
                <label for="old_password_confirmation">Confirm Old Password</label>
                <input id="old_password_confirmation" type="password" name="old_password_confirmation" required>
            </div>

            <div>
                <label for="new_password">New Password</label>
                <input id="new_password" type="password" name="new_password" required>
            </div>

            <div>
                <label for="new_password_confirmation">Confirm New Password</label>
                <input id="new_password_confirmation" type="password" name="new_password_confirmation" required>
            </div>

            <div>
                <button type="submit">Save Changes</button>
            </div>
        </form>
      </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle Edit Form on Button Click
    document.getElementById('editButton').addEventListener('click', function() {
        document.getElementById('editDiv').style.display = 'block';
    });
    document.getElementById('passwordButton').addEventListener('click', function() {
        document.getElementById('passwordDiv').style.display = 'block';
    });
</script>
@endsection
