<!-- Page Heading -->
@isset($heading)
    <h1 class="h3 mb-2 text-gray-800">Tables {{ $heading }}</h1>
@endisset

<!-- DataTales Example -->
<div class="card shadow mb-4">
    {{ $title }}
    @isset($search)
        {{ $search }}
    @endisset

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <colgroup>
                    {{ $colgroup }}
                </colgroup>
                <thead>
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
