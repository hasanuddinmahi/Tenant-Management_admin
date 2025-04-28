@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @php
            // Define the family fields
            $familyFields = ['father_name', 'mother_name', 'spouse_name'];

            // Detect if any family field has an error
            $hasFamilyError = false;
            foreach ($familyFields as $field) {
                if ($errors->has($field)) {
                    $hasFamilyError = true;
                    break;
                }
            }
        @endphp

        {{-- Show custom message if family error exists --}}
        @if ($hasFamilyError)
            <p>Please fill at least one of Father's Name, Mother's Name, or Spouse's Name.</p>
        @endif

        {{-- Show other errors except family fields --}}
        @foreach ($errors->getMessages() as $field => $messages)
            @if (!in_array($field, $familyFields))
                @foreach ($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            @endif
        @endforeach
    </ul>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
