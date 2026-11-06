<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Norte | Administración</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styleInicio.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon"/>
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand"><span class="brand-mark">N</span><span class="brand-name">norte<span
                        style="color:var(--green)">.</span></span></div>
            <div class="nav-label">MENÚ PRINCIPAL</div>
            <a class="nav-link active" href="{{ url('/products') }}"><span class="nav-icon">◈</span><span
                    class="nav-text">Productos</span></a>
            <a class="nav-link" href="{{ url('/clientes') }}"><span class="nav-icon">♙</span><span class="nav-text">Clientes</span></a>
            <div class="side-bottom">
                <div class="profile">
                    <div class="avatar">A</div>
                    <div class="profile-info"><strong>Administrador</strong><small>Panel de tienda</small></div>
                </div>
            </div>
        </aside>

        <main class="main" id="productos">
            <div class="topbar">
                <div class="breadcrumb">Administración&nbsp; / &nbsp;<strong>Productos</strong></div><a
                    class="store-link" href="/">↗ &nbsp;Salir</a>
            </div>
            <section class="intro">
                <div>
                    <div class="eyebrow">Catálogo</div>
                    <h1>Productos</h1>
                    <p>Administra el catálogo y el inventario de tu tienda.</p>
                </div><button class="primary" id="add-product"><span class="plus">＋</span>Agregar producto</button>
            </section>
            <section class="stats" aria-label="Resumen de productos">
                <div class="stat">
                    <div>
                        <div class="stat-label">Productos en catálogo</div>
                        <div class="stat-value" id="total-count">0</div>
                    </div>
                    <div class="stat-icon">◈</div>
                </div>
                <div class="stat">
                    <div>
                        <div class="stat-label">Unidades en inventario</div>
                        <div class="stat-value" id="stock-count">0</div>
                    </div>
                    <div class="stat-icon">▤</div>
                </div>
                <div class="stat">
                    <div>
                        <div class="stat-label">Stock bajo</div>
                        <div class="stat-value" id="low-count">0</div>
                    </div>
                    <div class="stat-icon">⌁</div>
                </div>
            </section>

            <div class="table-wrap">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Inventario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->nombre }}</td>
                                <td>{{ $product->categoria }}</td>
                                <td>${{ number_format($product->precio, 2) }}</td>
                                <td>{{ $product->inventario }}</td>
                                <td>
                                    <button class="edit-btn" type="button" data-id="{{ $product->id }}"
                                        data-nombre="{{ $product->nombre }}" data-categoria="{{ $product->categoria }}"
                                        data-precio="{{ $product->precio }}" data-inventario="{{ $product->inventario }}">Editar</button>
                                    <button class="delete-btn" type="button" data-id="{{ $product->id }}"
                                        data-nombre="{{ $product->nombre }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="empty" id="empty-state" hidden>No hay productos que coincidan con la búsqueda.</div>
            </div>
        </main>
    </div>

    <div class="modal-backdrop" id="product-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="modal">
            <div class="modal-head">
                <div>
                    <h2 id="modal-title">Nuevo producto</h2>
                    <p>Completa la información del producto.</p>
                </div><button class="close-btn" id="close-modal" aria-label="Cerrar">×</button>
            </div>
            <form id="product-form" action="{{ route('products.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="product-method" value="PUT" disabled>
                <div class="form-grid">
                    <div class="field full">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" name="nombre" maxlength="70" required
                            placeholder="Ej. Taza de cerámica">
                    </div>
                    <div class="field">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Seleccionar...</option>
                            <option value="Hogar">Hogar</option>
                            <option value="Accesorios">Accesorios</option>
                            <option value="Decoración">Decoración</option>
                            <option value="Ropa">Ropa</option>
                            <option value="Alimentos">Alimentos</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="precio">Precio ($)</label>
                        <input id="precio" name="precio" type="number" min="0.01" step="0.01" required
                            placeholder="0.00">
                    </div>
                    <div class="field">
                        <label for="inventario">Unidades en inventario</label>
                        <input id="inventario" name="inventario" type="number" min="0" step="1"
                            required placeholder="0">
                    </div>
                </div>

                <div class="form-error" id="form-error" role="alert"></div>

                <div class="modal-actions">
                    <button class="secondary" type="button" id="cancel-modal">Cancelar</button>
                    <button class="primary" type="submit">Guardar producto</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-backdrop" id="delete-modal" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
        <div class="modal">
            <div class="modal-head">
                <div>
                    <h2 id="delete-modal-title">Eliminar producto</h2>
                    <p id="delete-message">¿Seguro que deseas eliminar este producto?</p>
                </div>
                <button class="close-btn" id="close-delete-modal" type="button" aria-label="Cerrar">×</button>
            </div>
            <form id="delete-form" method="POST" action="{{ route('products.destroy', '__ID__') }}">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button class="secondary" type="button" id="cancel-delete">Cancelar</button>
                    <button class="delete-btn" type="submit">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="toast" id="toast" role="status"></div>

    <script>
        const modal = document.getElementById('product-modal');
        const productForm = document.getElementById('product-form');
        const productMethod = document.getElementById('product-method');
        const deleteModal = document.getElementById('delete-modal');
        const deleteForm = document.getElementById('delete-form');
        const storeAction = productForm.action;
        const updateAction = @json(route('products.update', '__ID__'));
        const destroyAction = @json(route('products.destroy', '__ID__'));

        const productRows = document.querySelectorAll('.product-table tbody tr');
        let inventoryTotal = 0;
        let lowStockTotal = 0;
        productRows.forEach(row => {
            const inventory = Number.parseInt(row.cells[3]?.textContent.trim(), 10) || 0;
            inventoryTotal += inventory;
            if (inventory <= 50) lowStockTotal++;
        });
        document.getElementById('total-count').textContent = productRows.length;
        document.getElementById('stock-count').textContent = inventoryTotal;
        document.getElementById('low-count').textContent = lowStockTotal;

        document.getElementById('add-product').addEventListener('click', () => {
            productForm.reset();
            productForm.action = storeAction;
            productMethod.disabled = true;
            document.getElementById('modal-title').textContent = 'Nuevo producto';
            modal.classList.add('open');
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                productForm.action = updateAction.replace('__ID__', encodeURIComponent(button.dataset.id));
                productMethod.disabled = false;
                document.getElementById('modal-title').textContent = 'Editar producto';
                document.getElementById('nombre').value = button.dataset.nombre;
                document.getElementById('categoria').value = button.dataset.categoria;
                document.getElementById('precio').value = button.dataset.precio;
                document.getElementById('inventario').value = button.dataset.inventario;
                modal.classList.add('open');
            });
        });

        document.querySelectorAll('.delete-btn[data-id]').forEach(button => {
            button.addEventListener('click', () => {
                deleteForm.action = destroyAction.replace('__ID__', encodeURIComponent(button.dataset.id));
                document.getElementById('delete-message').textContent =
                    `¿Seguro que deseas eliminar “${button.dataset.nombre}”? Esta acción no se puede deshacer.`;
                deleteModal.classList.add('open');
            });
        });

        const closeModal = () => modal.classList.remove('open');
        document.getElementById('close-modal').addEventListener('click', closeModal);
        document.getElementById('cancel-modal').addEventListener('click', closeModal);
        const closeDeleteModal = () => deleteModal.classList.remove('open');
        document.getElementById('close-delete-modal').addEventListener('click', closeDeleteModal);
        document.getElementById('cancel-delete').addEventListener('click', closeDeleteModal);
    </script>
</body>

</html>
