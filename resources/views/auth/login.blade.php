<x-guest-layout>
    <div class="auth-header">
        <h2><i class="fas fa-utensils"></i> Restaurantly</h2>
    </div>

    <!-- Login Form -->
    <div id="loginForm">
        <form class="auth-form" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            @error('email')<span class="error-message">{{ $message }}</span>@enderror
            
            <input type="password" name="password" placeholder="Password" required>
            @error('password')<span class="error-message">{{ $message }}</span>@enderror
            
           
            
            <button type="submit">Sign In</button>
        </form>

        <div class="form-footer">
            <a href="javascript:toggleForms()">Create an account</a>
         
        </div>
    </div>

    <!-- Register Form -->
    <div id="registerForm" style="display: none;">
        <form class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
            @error('name')<span class="error-message">{{ $message }}</span>@enderror
            
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')<span class="error-message">{{ $message }}</span>@enderror
            
            <input type="password" name="password" placeholder="Password" required>
            @error('password')<span class="error-message">{{ $message }}</span>@enderror
            
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            
            <button type="submit">Register</button>
        </form>

        <div class="form-footer">
            <a href="javascript:toggleForms()">Already have an account?</a>
        </div>
    </div>
</x-guest-layout>