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
            <a class="nav-link" href="{{ url('/products') }}"><span class="nav-icon">◈</span><span class="nav-text">Productos</span></a>
            <a class="nav-link active" href="{{ url('/clientes') }}"><span class="nav-icon">♙</span><span class="nav-text">Clientes</span></a>
            <div class="side-bottom">
                <div class="profile">
                    <div class="avatar">A</div>
                    <div class="profile-info"><strong>Administrador</strong><small>Panel de tienda</small></div>
                </div>
            </div>
        </aside>

        <main class="main" id="productos">
            <div class="topbar">
                <div class="breadcrumb">Administración&nbsp; / &nbsp;<strong>Clientes</strong></div><a
                    class="store-link" href="/">↗ &nbsp;Salir</a>
            </div>
            <section class="intro">
                <div>
                    <div class="eyebrow">Lista</div>
                    <h1>Clientes</h1>
                    <p>Administra la lista de Clientes.</p>
                </div><button class="primary" id="add-customer"><span class="plus">＋</span>Agregar cliente</button>
            </section>
            <section class="stats" aria-label="Resumen de clientes">
                <div class="stat">
                    <div>
                        <div class="stat-label">Total de clientes</div>
                        <div class="stat-value" id="total-customers">{{ $customers->count() }}</div>
                    </div>
                    <div class="stat-icon">◈</div>
                </div>
            </section>

            <div class="table-wrap">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Género</th>
                            <th>Teléfono</th>
                            <th>DNI</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->nombre }}</td>
                                <td>{{ $customer->genero }}</td>
                                <td>{{ $customer->telefono }}</td>
                                <td>{{ $customer->dni }}</td>
                                <td>
                                    <button class="edit-btn" type="button" data-id="{{ $customer->id }}"
                                        data-nombre="{{ $customer->nombre }}" data-genero="{{ $customer->genero }}"
                                        data-telefono="{{ $customer->telefono }}" data-dni="{{ $customer->dni }}">Editar</button>
                                    <button class="delete-btn" type="button" data-id="{{ $customer->id }}"
                                        data-nombre="{{ $customer->nombre }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="empty" id="empty-state" hidden>No hay clientes que coincidan con la búsqueda.</div>
            </div>
        </main>
    </div>

    <div class="modal-backdrop" id="customer-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="modal">
            <div class="modal-head">
                <div>
                    <h2 id="modal-title">Nuevo cliente</h2>
                    <p>Completa la información del cliente.</p>
                </div><button class="close-btn" id="close-modal" aria-label="Cerrar">×</button>
            </div>
            <form id="customer-form" action="{{ route('customers.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="customer-method" value="PUT" disabled>
                <div class="form-grid">
                    <div class="field full">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" name="nombre" maxlength="70" required
                            placeholder="Ej. Juan Pérez">
                    </div>
                    <div class="field">
                        <label for="genero">Género</label>
                        <select id="genero" name="genero" required>
                            <option value="">Seleccionar...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" name="telefono" type="tel" maxlength="9" required
                            placeholder="Ej. 999999999">
                    </div>
                    <div class="field">
                        <label for="dni">DNI</label>
                        <input id="dni" name="dni" type="text" maxlength="8" required placeholder="Ej. 12345678">
                    </div>
                </div>

                <div class="form-error" id="form-error" role="alert"></div>

                <div class="modal-actions">
                    <button class="secondary" type="button" id="cancel-modal">Cancelar</button>
                    <button class="primary" type="submit">Guardar cliente</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-backdrop" id="delete-modal" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
        <div class="modal">
            <div class="modal-head">
                <div>
                    <h2 id="delete-modal-title">Eliminar cliente</h2>
                    <p id="delete-message">¿Seguro que deseas eliminar este cliente?</p>
                </div>
                <button class="close-btn" id="close-delete-modal" type="button" aria-label="Cerrar">×</button>
            </div>
            <form id="delete-form" method="POST" action="{{ route('customers.destroy', '__ID__') }}">
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
        const modal = document.getElementById('customer-modal');
        const customerForm = document.getElementById('customer-form');
        const customerMethod = document.getElementById('customer-method');
        const deleteModal = document.getElementById('delete-modal');
        const deleteForm = document.getElementById('delete-form');
        const storeAction = customerForm.action;
        const updateAction = @json(route('customers.update', '__ID__'));
        const destroyAction = @json(route('customers.destroy', '__ID__'));

        document.getElementById('add-customer').addEventListener('click', () => {
            customerForm.reset();
            customerForm.action = storeAction;
            customerMethod.disabled = true;
            customerMethod.value = 'PUT';
            document.getElementById('modal-title').textContent = 'Nuevo cliente';
            modal.classList.add('open');
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                customerForm.action = updateAction.replace('__ID__', encodeURIComponent(button.dataset.id));
                customerMethod.disabled = false;
                customerMethod.value = 'PUT';
                document.getElementById('modal-title').textContent = 'Editar cliente';
                document.getElementById('nombre').value = button.dataset.nombre;
                document.getElementById('genero').value = button.dataset.genero || '';
                document.getElementById('telefono').value = button.dataset.telefono;
                document.getElementById('dni').value = button.dataset.dni;
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
