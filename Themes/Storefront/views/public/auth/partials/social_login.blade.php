@if (count($providers) !== 0)
    <span class="sign-in-with">
        @if (request()->routeIs('login'))
            {{ trans('user::auth.or_continue_with') }}
        @else
            {{ trans('user::auth.or_sign_up_with') }}
        @endif
    </span>

    <ul class="list-inline social-login">
        @if (setting('facebook_login_enabled'))
            <li>
                <a href="{{ route('login.redirect', ['provider' => 'facebook']) }}" title="{{ trans('user::auth.facebook') }}">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 500 500">
                        <g>
                            <g>
                                <g>
                                    <path fill="#0866ff" d="M500,250C500,111.93,388.07,0,250,0S0,111.93,0,250C0,367.24,80.72,465.62,189.61,492.64V326.4H138.05V250h51.56V217.08c0-85.09,38.5-124.53,122-124.53,15.84,0,43.17,3.1,54.35,6.21V168c-5.9-.62-16.15-.93-28.88-.93-41,0-56.83,15.53-56.83,55.9v27H362l-14,76.4H280.29V498.17C404.07,483.22,500,377.82,500,250Z"/>
                                    <path fill="#ffffff" d="M347.92,326.4,362,250H280.29V223c0-40.37,15.84-55.9,56.83-55.9,12.73,0,23,.31,28.88.93V98.76c-11.18-3.11-38.51-6.21-54.35-6.21-83.54,0-122,39.44-122,124.53V250H138.05v76.4h51.56V492.64a251.49,251.49,0,0,0,90.68,5.53V326.4Z"/>
                                </g>
                            </g>
                        </g>
                    </svg>
                </a>
            </li>
        @endif

        @if (setting('google_login_enabled'))
            <li>
                <a href="{{ route('login.redirect', ['provider' => 'google']) }}" title="{{ trans('user::auth.google') }}">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="https://www.w3.org/1999/xlink" style="display: block;">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                        <path fill="none" d="M0 0h48v48H0z"></path>
                    </svg>
                </a>
            </li>
        @endif
    </ul>
@endif
