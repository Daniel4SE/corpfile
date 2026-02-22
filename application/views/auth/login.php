<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: CorpFile - Corporate Secretarial System ::</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('public/images/favicon.png') ?>"/>
    <link href="<?= base_url('public/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('public/vendors/jquery/dist/jquery.min.js') ?>"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* ── Layout ─────────────────────────────────────── */
        .split-screen {
            display: flex;
            height: 100vh;
            min-height: 600px;
        }

        /* ── Left Panel ─────────────────────────────────── */
        .left-panel {
            width: 45%;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 60px;
            position: relative;
        }

        .left-panel .brand {
            text-align: center;
            margin-bottom: 36px;
        }
        .left-panel .brand img {
            max-width: 200px;
            max-height: 60px;
        }
        .left-panel .brand h2 {
            margin-top: 18px;
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
        }
        .left-panel .brand p {
            color: #888;
            font-size: 14px;
            margin-top: 4px;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .field-wrap {
            margin-bottom: 18px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #206570;
            font-size: 14px;
            z-index: 2;
            pointer-events: none;
        }
        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            color: #333;
            background: #fafafa;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .input-wrapper input:focus {
            border-color: #206570;
            box-shadow: 0 0 0 3px rgba(32,101,112,0.1);
            background: #fff;
        }
        .input-wrapper input::placeholder { color: #bbb; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #206570 0%, #159895 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: opacity 0.2s, transform 0.2s;
            margin-top: 6px;
        }
        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: 13px;
            color: #206570;
            text-decoration: none;
            margin-top: 14px;
            font-weight: 500;
        }
        .forgot-link:hover { text-decoration: underline; }

        /* ── Divider ─────────────────────────────────────── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #ccc;
            font-size: 13px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8e8e8;
        }

        /* ── Social Buttons ──────────────────────────────── */
        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: 1.5px solid #e0e0e0;
            background: #fff;
            color: #333;
            transition: background 0.15s, border-color 0.15s, box-shadow 0.15s;
            text-decoration: none;
            margin-bottom: 10px;
        }
        .btn-social:hover {
            background: #f7f7f7;
            border-color: #ccc;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            color: #333;
            text-decoration: none;
        }
        .btn-social svg { flex-shrink: 0; }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            color: #dc2626;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .footer-note {
            position: absolute;
            bottom: 20px;
            font-size: 12px;
            color: #bbb;
        }

        /* ── Right Panel ─────────────────────────────────── */
        .right-panel {
            width: 55%;
            position: relative;
            overflow: hidden;
            background: #042125;
        }

        .right-panel video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            opacity: 0.55;
        }

        .right-panel-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, #0a3d45 0%, #042125 60%, #010e10 100%);
        }

        .right-panel-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(4,33,37,0.85) 0%, rgba(4,33,37,0.3) 60%, transparent 100%);
        }

        .right-panel-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px 50px;
            color: #fff;
        }

        .right-panel-content .tagline {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }
        .right-panel-content .tagline span {
            color: #57d5d5;
        }
        .right-panel-content .desc {
            font-size: 15px;
            color: rgba(255,255,255,0.7);
            line-height: 1.7;
            max-width: 420px;
        }

        .features {
            display: flex;
            gap: 24px;
            margin-top: 32px;
        }
        .feature-item {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 14px 18px;
            flex: 1;
        }
        .feature-item .fi-icon {
            font-size: 20px;
            color: #57d5d5;
            margin-bottom: 8px;
        }
        .feature-item .fi-title {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }
        .feature-item .fi-desc {
            font-size: 12px;
            color: rgba(255,255,255,0.55);
            margin-top: 3px;
        }

        /* ── Responsive ─────────────────────────────────── */
        @media (max-width: 768px) {
            .right-panel { display: none; }
            .left-panel { width: 100%; padding: 40px 30px; }
        }
    </style>
</head>
<body>
<div class="split-screen">

    <!-- ── Left: Login Form ────────────────────────────── -->
    <div class="left-panel">
        <div class="login-box">

            <div class="brand">
                <img src="<?= base_url('public/images/corpfile-logo.png') ?>" alt="CorpFile">
                <h2>Welcome back</h2>
            </div>

            <?php if (!empty($error_message)): ?>
            <div class="alert-error">
                <i class="fa fa-exclamation-circle"></i>
                <?= htmlspecialchars($error_message) ?>
            </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('welcome/login') ?>">
                <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?>"/>
                <input type="hidden" name="ulogin" value="1"/>

                <div class="field-wrap">
                    <label class="form-label">Company ID</label>
                    <div class="input-wrapper">
                        <i class="fa fa-building field-icon"></i>
                        <input type="text" name="client_id" placeholder="Enter your Company ID"
                               value="<?= htmlspecialchars($_POST['client_id'] ?? '') ?>">
                    </div>
                </div>

                <div class="field-wrap">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <i class="fa fa-user field-icon"></i>
                        <input type="text" name="uname" placeholder="Enter your username"
                               value="<?= htmlspecialchars($_POST['uname'] ?? '') ?>">
                    </div>
                </div>

                <div class="field-wrap">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-lock field-icon"></i>
                        <input type="password" name="upsd" placeholder="Enter your password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa fa-sign-in" style="margin-right:8px;"></i> Sign In
                </button>
            </form>

            <a class="forgot-link" href="<?= base_url('welcome/forgot_password') ?>">
                Forgot Password?
            </a>

            <div class="divider">or continue with</div>

            <!-- Google (Firebase Auth) -->
            <button type="button" id="btn-google-login" class="btn-social" onclick="signInWithGoogle()">
                <svg width="18" height="18" viewBox="0 0 48 48">
                    <path fill="#4285F4" d="M47.5 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h13.2c-.6 3-2.3 5.5-4.9 7.2v6h7.9c4.6-4.3 7.3-10.6 7.3-17.2z"/>
                    <path fill="#34A853" d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-7.9-6c-2.1 1.4-4.9 2.3-8 2.3-6.1 0-11.3-4.1-13.2-9.7H2.6v6.2C6.6 42.7 14.7 48 24 48z"/>
                    <path fill="#FBBC05" d="M10.8 28.8c-.5-1.4-.7-2.9-.7-4.4s.2-3 .7-4.4v-6.2H2.6C.9 17.2 0 20.5 0 24s.9 6.8 2.6 9.7l8.2-4.9z"/>
                    <path fill="#EA4335" d="M24 9.5c3.4 0 6.5 1.2 8.9 3.5l6.6-6.6C35.9 2.6 30.4 0 24 0 14.7 0 6.6 5.3 2.6 13l8.2 6.2C12.7 13.6 17.9 9.5 24 9.5z"/>
                </svg>
                <span id="google-btn-text">Continue with Google</span>
            </button>

            <!-- Microsoft (Firebase Auth) -->
            <button type="button" id="btn-microsoft-login" class="btn-social" onclick="signInWithMicrosoft()">
                <svg width="18" height="18" viewBox="0 0 21 21">
                    <rect x="1" y="1" width="9" height="9" fill="#F25022"/>
                    <rect x="11" y="1" width="9" height="9" fill="#7FBA00"/>
                    <rect x="1" y="11" width="9" height="9" fill="#00A4EF"/>
                    <rect x="11" y="11" width="9" height="9" fill="#FFB900"/>
                </svg>
                <span id="ms-btn-text">Continue with Microsoft</span>
            </button>

            <div id="social-login-error" style="display:none;" class="alert-error" role="alert"></div>

        </div>

        <span class="footer-note">© <?= date('Y') ?> CorpFile. All rights reserved.</span>
    </div>

    <!-- ── Right: Branding Panel ───────────────────────── -->
    <div class="right-panel">
        <div class="right-panel-bg"></div>
        <video autoplay muted loop playsinline>
            <source src="<?= base_url('public/videos/tech_bg.mp4') ?>" type="video/mp4">
        </video>
        <div class="right-panel-overlay"></div>

        <div class="right-panel-content">
            <div class="tagline">
                Built for<br>
                <span>Corporate Secretaries,</span><br>
                by Experts.
            </div>
            <p class="desc">
                CorpFile streamlines your corporate secretarial work — from company registration
                and share management to AGM tracking and statutory compliance, all in one place.
            </p>
            <div class="features">
                <div class="feature-item">
                    <div class="fi-icon"><i class="fa fa-building"></i></div>
                    <div class="fi-title">Company Management</div>
                    <div class="fi-desc">Full lifecycle tracking</div>
                </div>
                <div class="feature-item">
                    <div class="fi-icon"><i class="fa fa-calendar-check-o"></i></div>
                    <div class="fi-title">Event Tracker</div>
                    <div class="fi-desc">AGM, AR & due dates</div>
                </div>
                <div class="feature-item">
                    <div class="fi-icon"><i class="fa fa-file-text"></i></div>
                    <div class="fi-title">Documents</div>
                    <div class="fi-desc">eSign & file management</div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Firebase JS SDK (modular compat) -->
<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-auth-compat.js"></script>
<script>
// Firebase config from server
const firebaseConfig = {
    apiKey: "<?= config_item('firebase')['apiKey'] ?>",
    authDomain: "<?= config_item('firebase')['authDomain'] ?>",
    projectId: "<?= config_item('firebase')['projectId'] ?>",
    appId: "<?= config_item('firebase')['appId'] ?>"
};
firebase.initializeApp(firebaseConfig);

const BASE_URL = "<?= base_url() ?>";

function showSocialError(msg) {
    const el = document.getElementById('social-login-error');
    el.textContent = msg;
    el.style.display = 'block';
}
function hideSocialError() {
    document.getElementById('social-login-error').style.display = 'none';
}

/**
 * After Firebase sign-in, send the ID token to the PHP backend
 */
async function sendTokenToBackend(user) {
    const idToken = await user.getIdToken();
    const resp = await fetch(BASE_URL + 'welcome/firebase_login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_token: idToken })
    });
    const data = await resp.json();
    if (data.success && data.redirect) {
        window.location.href = data.redirect;
    } else {
        showSocialError(data.error || 'Login failed. Please try again.');
    }
}

/**
 * Google Sign-In via Firebase popup
 */
async function signInWithGoogle() {
    hideSocialError();
    const btn = document.getElementById('btn-google-login');
    const btnText = document.getElementById('google-btn-text');
    btn.disabled = true;
    btnText.textContent = 'Signing in...';

    try {
        const provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('email');
        provider.addScope('profile');
        const result = await firebase.auth().signInWithPopup(provider);
        await sendTokenToBackend(result.user);
    } catch (err) {
        console.error('Google sign-in error:', err);
        if (err.code !== 'auth/popup-closed-by-user' && err.code !== 'auth/cancelled-popup-request') {
            showSocialError(err.message || 'Google sign-in failed.');
        }
        btn.disabled = false;
        btnText.textContent = 'Continue with Google';
    }
}

/**
 * Microsoft Sign-In via Firebase popup
 */
async function signInWithMicrosoft() {
    hideSocialError();
    const btn = document.getElementById('btn-microsoft-login');
    const btnText = document.getElementById('ms-btn-text');
    btn.disabled = true;
    btnText.textContent = 'Signing in...';

    try {
        const provider = new firebase.auth.OAuthProvider('microsoft.com');
        provider.addScope('openid');
        provider.addScope('email');
        provider.addScope('profile');
        const result = await firebase.auth().signInWithPopup(provider);
        await sendTokenToBackend(result.user);
    } catch (err) {
        console.error('Microsoft sign-in error:', err);
        if (err.code !== 'auth/popup-closed-by-user' && err.code !== 'auth/cancelled-popup-request') {
            showSocialError(err.message || 'Microsoft sign-in failed.');
        }
        btn.disabled = false;
        btnText.textContent = 'Continue with Microsoft';
    }
}
</script>
</body>
</html>
