<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-20 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-calendar-event me-1"></i> SIMPA Schedule</span>
                    <h2 class="fw-bold text-white mb-2">Kalender Timeline Progres</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Visualisasi jadwal dan histori pengerjaan aplikasi di seluruh unit kerja Surveyor Indonesia.</p>
                </div>
                <div class="d-none d-md-block opacity-25">
                    <i class="ti ti-calendar text-white" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body p-4">
        <div id='calendar' class="calendar-app"></div>
    </div>
</div>

<style>
    .fc-header-toolbar { padding: 10px; }
    .fc-toolbar-title { font-weight: 800; color: #1e293b; font-family: 'Inter', sans-serif !important; }
    .fc-button-primary { background-color: #0d6efd !important; border-color: #0d6efd !important; border-radius: 8px !important; font-weight: 600 !important; }
    .fc-event { border-radius: 6px !important; padding: 2px 5px; cursor: pointer; transition: transform 0.2s; }
    .fc-event:hover { transform: scale(1.02); }
    .fc-daygrid-event { white-space: normal !important; }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      themeSystem: 'bootstrap5',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listMonth'
      },
      events: '<?= base_url('calendar/events') ?>',
      eventClick: function(info) {
        alert('Proyek: ' + info.event.title + '\nKeterangan: ' + info.event.extendedProps.description);
      }
    });
    calendar.render();
  });
</script>
<?= $this->endSection() ?>
