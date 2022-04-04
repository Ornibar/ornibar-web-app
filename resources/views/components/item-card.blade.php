@props(['disabled' => false, 'label' => $label, 'routes' => $routes, 'test' => $test])

<div class="w-full bg-gray-100 px-10 pt-10">
    <div class="container mx-auto">
        <div role="list" class="lg:flex md:flex sm:flex items-center xl:justify-between flex-wrap md:justify-around sm:justify-around lg:justify-around">
            <div role="listitem" class="xl:w-1/3 sm:w-3/4 md:w-2/5 relative mt-16 mb-32 sm:mb-24 xl:max-w-sm lg:w-2/5">
                <div class="rounded overflow-hidden shadow-md bg-white">
                    <h1 class="font-bold text-xl mb-2">{{ $label }}</h1>
                    <div class="px-6 mt-16">
                        <ul>
                            @for($i = 0; $i < count($routes); $i++)
                                @foreach ($test as $route)
                                    {{-- @php dump($route->getName()); @endphp  --}}
                                    @if(strpos($route->getName(), $routes[$i]) !== false)
                                        <li> 
                                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route($route->getName()) }}">{{ __($route->getName()) }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endfor
                        </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>