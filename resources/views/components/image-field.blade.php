@props([
    'id' => \Illuminate\Support\Str::ulid(),
    'value' => null,
])

@php
    $componentId = "image-field-$id";
@endphp
<div class="flex gap-x-4 items-center" id="{{ $componentId }}">
    <input {{ $attributes }} class="hidden" id="{{ $id }}" type="file" />
    <div
        class="border flex items-center relative justify-center border-dashed border-zinc-950/10 bg-zinc-50 size-20 rounded-md"
        data-preview-container
    >
        <svg
            class="fill-zinc-500"
            height="20"
            viewBox="0 0 512 512"
            width="20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M280 360c0 13.3-10.7 24-24 24s-24-10.7-24-24V81.9l-95 95c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L239 7c9.4-9.4 24.6-9.4 33.9 0L409 143c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-95-95V360zm32-8V304H448c35.3 0 64 28.7 64 64v80c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V368c0-35.3 28.7-64 64-64H200v48H64c-8.8 0-16 7.2-16 16v80c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V368c0-8.8-7.2-16-16-16H312zm72 56a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
        </svg>
        @if ($value)
            <img
                class="max-w-none rounded-md absolute size-[calc(100%+theme(spacing[0.5]))] object-center object-cover -top-px -start-px"
                src="{{ $value }}"
            />
        @endif
    </div>
    <button type="button">Upload</button>
</div>

<script>
    (function  () {
        const scope = document.querySelector('#{{ $componentId }}')

        const buttonEl = scope.querySelector('button')
        const inputEl = scope.querySelector('input')
        const previewContainerEl = scope.querySelector('[data-preview-container]')

        buttonEl.addEventListener('click', () => {
            inputEl.click()
        })

        let previewObjectURL = null

        inputEl.addEventListener('change', (e) => {
            if (previewObjectURL !== null) {
                previewContainerEl.querySelector('[data-preview]')?.remove()

                URL.revokeObjectURL(previewObjectURL)

                previewObjectURL = null
            }

            const file = e.target.files[0]

            if (file === undefined) {
                return
            }

            previewObjectURL = URL.createObjectURL(file)

            const imageEl = document.createElement('img')

            imageEl.className = 'max-w-none rounded-md absolute size-[calc(100%+theme(spacing[0.5]))] object-center object-cover -top-px -start-px'
            imageEl.dataset.preview = ''
            imageEl.src = previewObjectURL

            previewContainerEl.appendChild(imageEl)
        })
    })()
</script>
