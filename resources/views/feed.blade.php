<x-layout :title="'Feed - EYES CARE'">

  <body class="bg-eyes-care-dark text-eyes-care-light flex gap-8 px-4 sm:h-dvh sm:overflow-clip xl:gap-16">
    {{-- Navigation --}}
    @include('partials.navigation')

    {{-- Content --}}
    <main class="-mx-4 flex grow flex-col gap-4 overflow-y-auto px-4 py-4">
      <div class="h-full">
        <nav class="overflow-x-auto [scrollbar-width:none]">
          <ul class="flex min-w-max justify-end gap-8 text-sm">
            <li><a href="#">For you</a></li>
            <li>
              <a class="text-eyes-care-light/60 hover:text-eyes-care-light/80" href="#">Idea streams</a>
            </li>
            <li>
              <a class="text-eyes-care-light/60 hover:text-eyes-care-light/80" href="#">Following</a>
            </li>
          </ul>
        </nav>
      </div>

      {{-- Post prompt --}}
      <div class="border-eyes-care-light/10 mt-8 flex items-start gap-4 border-b pb-4">
        <a href="/profile" class="shrink-0">
          <img src="/images/adrian.png" alt="Avatar for Adrian" class="size-10 object-cover" />
        </a>
        @include('partials.post-form', [
        'labelText' => 'Post body',
        'fieldName' => 'post',
        'placeholder'=> "What's happening?",
        ])
      </div>

      <!-- Feed -->
      <ol class="mt-4">
        @foreach ($feedItems as $item)
        @include('partials.feed-item',compact('item'))
        @endforeach
      </ol>

      <footer class="mt-30 ml-14">
        <p class="text-center">That's all, folks!</p>
        <hr class="border-eyes-care-light/10 my-4" />
        <!-- White noise -->
        <div class="h-20 bg-[url(/resources/images/white-noise.gif)]"></div>
      </footer>
    </main>

    {{-- Aside --}}
    @include('partials.aside')
</x-layout>
