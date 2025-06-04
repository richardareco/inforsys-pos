<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inforsys Pos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #007bff; /* Azul claro */
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }
        .menu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 40px 20px;
        }
        .menu-box {
            background-color: white;
            color: #007bff;
            width: 130px;
            height: 130px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease;
        }
        .menu-box:hover {
            transform: scale(1.05);
        }
        .menu-box i {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .titulo {
            text-align: center;
            padding-top: 30px;
            font-size: 28px;
            font-weight: bold;
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="titulo">Inforsys Pos</div>

    <div class="menu-container">
        <a href="{{ route('clientes.index') }}" class="menu-box">
            <i class="fas fa-users"></i>
            Clientes
        </a>
        <a href="{{ route('pedidos.create') }}" class="menu-box">
            <i class="fas fa-shopping-cart"></i>
            Pedidos
        </a>
        <a href="#" class="menu-box">
            <i class="fas fa-chart-line"></i>
            Dashboard
        </a>
        <a href="#" class="menu-box">
            <i class="fas fa-box-open"></i>
            Productos
        </a>
    </div>

</body>
</html>
