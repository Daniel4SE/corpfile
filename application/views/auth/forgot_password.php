<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: CorpFile - Forgot Password ::</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('public/images/favicon.png') ?>"/>
    <link href="<?= base_url('public/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            height: 100%;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0a1628 0%, #1a2a4a 50%, #0d1f3c 100%);
        }
        .forgot-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .forgot-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 50px 40px;
            max-width: 450px;
            width: 100%;
        }
        .forgot-box h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1a2a4a;
            margin-bottom: 8px;
        }
        .forgot-box p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .forgot-box label {
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: block;
            font-size: 13px;
        }
        .forgot-box .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .forgot-box .form-control:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33,150,243,0.1);
        }
        .forgot-box .btn-primary {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .forgot-box .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(26,115,232,0.4);
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #1a73e8;
            font-size: 14px;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .alert { border-radius: 8px; font-size: 14px; }
        .brand-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .brand-logo img {
            max-height: 50px;
        }
        .brand-logo .brand-text {
            font-size: 22px;
            font-weight: 700;
            color: #1a2a4a;
            letter-spacing: -0.5px;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-box">
            <div class="brand-logo">
                <span class="brand-text">CorpFile</span>
            </div>
            
            <h2>Forgot Password</h2>
            <p>Enter your registered email address below. If your account exists, we will send you a password reset link.</p>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('welcome/forgot_password') ?>">
                <div class="form-group">
                    <label>Company ID</label>
                    <input type="text" name="client_id" class="form-control" placeholder="e.g. SG123" required>
                </div>
                <div class="form-group" style="margin-top: 15px;">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-paper-plane"></i> Send Reset Link
                </button>
            </form>

            <a class="back-link" href="<?= base_url('welcome') ?>">
                <i class="fa fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>
</body>
</html>
