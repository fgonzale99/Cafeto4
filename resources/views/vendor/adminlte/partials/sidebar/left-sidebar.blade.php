<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @foreach (\Backpack\MenuCRUD\app\Models\MenuItem::getTree(); as $item)
                  @if($item->active ==1)
                    @php
                      $params = array();
                      if($item->params){
                        $params = (array) json_decode($item->params);
                      }
                    @endphp
                    @can($item->permission)
                      <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route($item->link, $params) }}">
                           <i class="fa {{ $item->icon }} nav-icon"></i>
                           <p>{{ $item->name }}</p>
                        </a>
                      </li>
                    @endcan
                  @endif
                @endforeach
            </ul>
        </nav>
    </div>

</aside>
