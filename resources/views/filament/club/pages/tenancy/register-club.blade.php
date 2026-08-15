<div>
    <style>
        .kcms-login-wrap { position: fixed; inset: 0; z-index: 40; display: flex; background: #fff; overflow-y: auto; }
        html.dark .kcms-login-wrap { background: #0b0f19; }

        .kcms-login-form-col { flex: 1 1 50%; display: flex; align-items: center; justify-content: center; padding: 3rem 1.5rem; min-width: 0; }
        .kcms-login-card { width: 100%; max-width: 24rem; }

        .kcms-login-logo { height: 3rem; width: auto; margin: 0 auto 1rem; display: block; }
        .kcms-login-logo.kcms-logo-dark { display: none; }
        html.dark .kcms-login-logo.kcms-logo-light { display: none; }
        html.dark .kcms-login-logo.kcms-logo-dark { display: block; }

        .kcms-login-heading { text-align: center; margin-bottom: 2rem; }
        .kcms-login-heading h1 { font-size: 1.5rem; font-weight: 700; color: #0b0f19; margin: 0; }
        html.dark .kcms-login-heading h1 { color: #fff; }
        .kcms-login-heading p { font-size: .875rem; color: #6b7280; margin-top: .25rem; }

        .kcms-login-submit {
            width: 100%; margin-top: 1.5rem; padding: .625rem 1rem; border-radius: .5rem;
            border: none; font-weight: 600; font-size: .875rem; color: #fff;
            background: #2563eb; cursor: pointer;
        }
        .kcms-login-submit:hover { opacity: .9; }

        .kcms-login-panel-col {
            flex: 1 1 50%; display: none; position: relative; overflow: hidden;
            padding: 4rem 3rem; color: #fff;
            background: linear-gradient(135deg, #2563eb, #1e3a8a);
            flex-direction: column; justify-content: center;
        }
        @media (min-width: 1024px) { .kcms-login-panel-col { display: flex; } }

        .kcms-login-panel-inner { max-width: 28rem; position: relative; z-index: 10; }
        .kcms-login-panel-inner h2 { font-size: 1.875rem; font-weight: 700; margin: 0; }
        .kcms-login-panel-inner > p { margin-top: .75rem; opacity: .85; }

        .kcms-feature-list { list-style: none; margin: 2.5rem 0 0; padding: 0; display: flex; flex-direction: column; gap: 1.5rem; }
        .kcms-feature-item { display: flex; align-items: flex-start; gap: 1rem; }
        .kcms-feature-icon { flex-shrink: 0; width: 1.25rem; height: 1.25rem; display: flex; align-items: center; justify-content: center; margin-top: 2px; }
        .kcms-feature-item strong { display: block; font-weight: 600; }
        .kcms-feature-item span { display: block; margin-top: .125rem; font-size: .875rem; opacity: .85; }
    </style>

    <div class="kcms-login-wrap">

        <div class="kcms-login-form-col">
            <div class="kcms-login-card">

                <div class="kcms-login-heading">
                    <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="kcms-login-logo kcms-logo-light" />
                    <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name') }}" class="kcms-login-logo kcms-logo-dark" />
                    <h1>{{ __('register-club.form.heading') }}</h1>
                    <p>{{ __('register-club.form.subheading') }}</p>
                </div>

                <form wire:submit="register">
                    {{ $this->form }}
                    <button type="submit" class="kcms-login-submit">
                        {{ __('register-club.form.submit') }}
                    </button>
                </form>

            </div>
        </div>

        <div class="kcms-login-panel-col">
            <div class="kcms-login-panel-inner">
                <h2>{{ __('register-club.panel.heading') }}</h2>
                <p>{{ __('register-club.panel.subheading') }}</p>

                <ul class="kcms-feature-list">
                    @foreach (__('register-club.panel.features') as $feature)
                        <li class="kcms-feature-item">
                            <span class="kcms-feature-icon">
                                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;">
                                    <path d="M5 10.5L8.5 14L15 6.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <div>
                                <strong>{{ $feature['title'] }}</strong>
                                <span>{{ $feature['description'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>