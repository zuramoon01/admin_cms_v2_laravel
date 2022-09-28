<x-dashboard :menus="$menus">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    @isset(request()->authorization_message)
        <div class="text-danger">
            <p>{{ request()->authorization_message }}</p>
        </div>
    @endisset
</x-dashboard>
