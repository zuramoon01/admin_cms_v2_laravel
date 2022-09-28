<!DOCTYPE html>
<html lang="en">

<head>
    <x-partials._head-content />
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>

                                    <form class="user" action="{{ url('/login') }}" method="post">
                                        @csrf

                                        @if ($errors->hasAny(['username', 'password']))
                                            <!-- Error Message -->
                                            <div class="alert alert-danger" role="alert">
                                                Username atau Password yang anda masukkan salah!
                                            </div>
                                            <!-- End of Error Message -->
                                        @endif

                                        <div class="form-group">
                                            {{-- prettier-ignore --}}
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                                        </div>

                                        <div class="form-group">
                                            {{-- prettier-ignore --}}
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-partials._js />
</body>

</html>
