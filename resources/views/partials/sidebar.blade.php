<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @foreach ($tableNames as $table)
        <li class="nav-item">
            <a href="{{ url('/' . Str::plural(strtolower($table))) }}" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>{{ ucfirst($table) }}</p>
            </a>
        </li>
    @endforeach
</ul>
