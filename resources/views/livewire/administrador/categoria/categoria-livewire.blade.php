<div>
    <!--SEO-->
    @section('tituloPagina', 'Categorias')

    <!--TITULO-->
    <h1>Categorias</h1>

    <!--FORMULARIOS-->
    <form wire:submit.prevent="crearCategoria">
        <!--NOMBRE-->
        <div>
            <p>Nombre: </p>
            <input type="text" wire:model="crearFormulario.nombre">
            @error('crearFormulario.nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--SLUG-->
        <div>
            <p>Slug: </p>
            <input type="text" wire:model="crearFormulario.slug">
            @error('crearFormulario.slug')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DESCRIPCIÓN-->
        <div>
            <p>Descripción: </p>
            <input type="text" wire:model="crearFormulario.descripcion">
            @error('crearFormulario.descripcion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--ENVIAR-->
        <div>
            <input type="submit" value="Crear Categoria">
        </div>
    </form>


    @if ($categorias->count())
        <!--SUBTITULO-->
        <h1>Lista Categorias</h1>

        <!--TABLA-->
        <table>
            <thead>
                <tr>
                    <th>
                        Nombre</th>
                    <th>
                        Ruta</th>
                    <th>
                        Descripción</th>
                    <th>
                        Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td>

                            {{ $categoria->nombre }}
                        </td>
                        <td>
                            {{ $categoria->slug }}
                        </td>
                        <td>
                            {{ Str::limit($categoria->descripcion, 20) }}
                        </td>
                        <td>
                            <a wire:click="editarCategoria('{{ $categoria->slug }}')">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a> |
                            <a wire:click="$emit('eliminarCategoriaModal', '{{ $categoria->slug }}')">
                                <span><i class="fa-solid fa-trash"></i></span>
                                Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay categorias.</p>
    @endif

    @if ($categoria)
        <!--MODAL-->
        <x-jet-dialog-modal wire:model="editarFormulario.abierto">
            <!--TITULO-->
            <x-slot name="title">
                <div>
                    <!--ENCABEZADO-->
                    <div>
                        <h2>Editar</h2>
                    </div>

                    <!--CERRAR-->
                    <div>
                        <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </x-slot>
            <!--CONTENIDO-->
            <x-slot name="content">

                <!--NOMBRE-->
                <div>
                    <p>Nombre: </p>
                    <input type="text" wire:model="editarFormulario.nombre">
                    @error('editarFormulario.nombre')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--SLUG-->
                <div>
                    <p>Slug: </p>
                    <input type="text" wire:model="editarFormulario.slug">
                    @error('editarFormulario.slug')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--DESCRIPCIÓN-->
                <div>
                    <p>Descripción: </p>
                    <input type="text" wire:model="editarFormulario.descripcion">
                    @error('editarFormulario.descripcion')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled"
                        type="submit">Cancelar</button>

                    <button wire:click="actualizarCategoria" wire:loading.attr="disabled"
                        wire:target="actualizarCategoria" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>

<!--SCRIPT-->
@push('script')
    <script>
        Livewire.on('eliminarCategoriaModal', categoriaId => {
            Swal.fire({
                title: '¿Quieres eliminar?',
                text: "No podrás recuparlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('administrador.categoria.categoria-livewire',
                        'eliminarCategoria', categoriaId);
                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    );
                }
            })
        });
    </script>
@endpush
