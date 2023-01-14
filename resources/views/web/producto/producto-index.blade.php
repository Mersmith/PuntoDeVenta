<x-web-layout>
    <!--SEO-->
    @section('tituloPagina', 'Producto | ' . $producto->nombre)

    <!--CONTENIDO PÁGINA-->
    <h1>{{ $producto->nombre }} </h1>
    
</x-web-layout>
