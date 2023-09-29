<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Laporan Siswa</title>
  @include('pdf.css')
</head>
<body>
  <section class="mb-8">
    <h2 class="h2">Data Siswa</h2>
    <table class="w-full">
      <tr class="pb-1">
        <td width="20%"><b>Nama</b></td>
        <td>: {{ $student->name }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>NISN</b></td>
        <td>: {{ $student->nisn }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>Kelas</b></td>
        <td>: {{ $student->grade->name }} {{ $student->generation->name }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>Wali Kelas</b></td>
        <td>: {{ $teacher[0]->name }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>Jenis Kelamin</b></td>
        <td>: {{ $student->gender }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>Tempat, Tanggal Lahir</b></td>
        <td>: {{ $student->place_birth}}, {{ date('d-m-Y', strtotime($student->date_birth)) }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>Total Point Prestasi</b></td>
        <td>: {{ $achievementData['sum'] }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>Total Point Pelanggaran</b></td>
        <td>: {{ $violationData['sum'] }}/{{ Setting::get('violation.initial_point') }}</td>
      </tr>
      <tr class="pb-1">
        <td width="20%"><b>Total Point</b></td>
        <td>: {{ $totalPoint }}</td>
      </tr>
    </table>
  </section>
  <section class="mb-8">
    <h2 class="h2">Prestasi</h2>
    <table class="table table-bordered table-hover w-100 w-full" id="tableViolation">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>Prestasi</th>
          <th>Point</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($achievements as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->achievement->name }}</td>
            <td>{{ $item->achievement->point }}</td>
            <td>{{ $item->created_at->format('d-m-Y h:i:s') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>
  <section class="mb-8">
    <h2 class="h2">Pelanggaran</h2>
    <table class="table table-bordered table-hover w-100 w-full" id="tableViolation">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>Pelanggaran</th>
          <th>Point</th>
          <th>Oleh</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($violations as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->violation->name }}</td>
            <td>{{ $item->violation->point }}</td>
            <td>{{ $item->student->name }}</td>
            <td>{{ $item->created_at->format('d-m-Y h:i:s') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>
</body>
</html>
