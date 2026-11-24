@error('map')
    <div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror
@vite('resources/whodoku/js/orchid-map-editor.ts', 'build/whodoku')
<div id="killdoku-map-editor" data-puzzle='@json($puzzle)' data-map='@json($map)' data-kinds='@json($kinds)'></div>
