<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AWN Test</title>

    <!-- AWN CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/awesome-notifications@3.1.5/dist/style.css">
</head>
<body>

<h2>Test Page for AWN Notification</h2>

<!-- AWN JS -->
<script src="https://cdn.jsdelivr.net/npm/awesome-notifications@3.1.5/dist/index.var.js"></script>
<script src="https://unpkg.com/awesome-notifications@3.1.5/dist/index.var.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const notifier = new AWN();

        @if(session('success'))
            notifier.success(@json(session('success')));
        @endif

        @if(session('error'))
            notifier.alert(@json(session('error')));
        @endif

        @if(session('warning'))
            notifier.warning(@json(session('warning')));
        @endif
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM loaded");
        const notifier = new AWN();
        notifier.success("This is a test success toast!");
    });
</script>

</body>
</html>
