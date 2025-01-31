{{-- Success Alert --}}
<x-alert 
    type="success" 
    :message="session('success')" 
/>

{{-- Error Alert --}}
<x-alert 
    type="error" 
    :message="session('error')" 
/>

{{-- Warning Alert --}}
<x-alert 
    type="warning" 
    :message="session('warning')" 
/>

{{-- Info Alert --}}
<x-alert 
    type="info" 
    :message="session('info')" 
/>
