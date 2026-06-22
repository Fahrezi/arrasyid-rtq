<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Redirecting to payment...</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #ffffff;
      font-family: system-ui, -apple-system, sans-serif;
      color: #374151;
    }
    .spinner {
      width: 48px;
      height: 48px;
      border: 4px solid #d1fae5;
      border-top-color: #22c55e;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      margin-bottom: 20px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    p { font-size: 15px; color: #6b7280; }
  </style>
</head>
<body>
  <div class="spinner"></div>
  <p>Redirecting to payment page...</p>
  <script>
    const url = @json($redirectUrl);
    if (url) {
      window.location.href = url;
    }
  </script>
</body>
</html>
