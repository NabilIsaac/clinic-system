<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription #{{ $prescription->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .prescription-info {
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
        .medications {
            margin-top: 30px;
        }
        .medication {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Medical Prescription</h1>
    </div>

    <div class="prescription-info">
        <div class="info-item">
            <span class="label">Prescription ID:</span> #{{ $prescription->id }}
        </div>
        <div class="info-item">
            <span class="label">Date:</span> {{ $prescription->created_at->format('M d, Y') }}
        </div>
        <div class="info-item">
            <span class="label">Doctor:</span> Dr. {{ $prescription->doctor->name }}
        </div>
        <div class="info-item">
            <span class="label">Patient:</span> {{ $prescription->patient->name }}
        </div>
    </div>

    <div class="diagnosis">
        <h3>Diagnosis</h3>
        <p>{{ $prescription->diagnosis }}</p>
    </div>

    @if($prescription->notes)
        <div class="notes">
            <h3>Notes</h3>
            <p>{{ $prescription->notes }}</p>
        </div>
    @endif

    <div class="medications">
        <h3>Prescribed Medications</h3>
        @foreach($prescription->medications as $medication)
            <div class="medication">
                <div class="info-item">
                    <span class="label">Medication:</span> {{ $medication->medication_name }}
                </div>
                <div class="info-item">
                    <span class="label">Dosage:</span> {{ $medication->dosage }}
                </div>
                <div class="info-item">
                    <span class="label">Frequency:</span> {{ $medication->frequency }}
                </div>
                <div class="info-item">
                    <span class="label">Duration:</span> {{ $medication->duration }} {{ $medication->duration_unit }}
                </div>
                @if($medication->special_instructions)
                    <div class="info-item">
                        <span class="label">Special Instructions:</span> {{ $medication->special_instructions }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="footer">
        <p>Doctor's Signature: _________________</p>
    </div>
</body>
</html>