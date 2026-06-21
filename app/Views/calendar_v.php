<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm bg-white">
            <div class="card-body p-4 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 border-start border-4 border-primary">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 fs-2 fw-medium px-3 py-1 rounded-pill"><i class="ti ti-calendar-event me-1"></i> SIMPA Schedule</span>
                    <h4 class="fw-bold text-dark mb-1">Kalender Timeline Progres</h4>
                    <p class="mb-0 text-muted" style="max-width: 600px;">Visualisasi jadwal dan histori pengerjaan aplikasi di seluruh unit kerja Surveyor Indonesia.</p>
                </div>
                <div class="d-none d-md-block opacity-25 text-end">
                    <i class="ti ti-calendar text-primary" style="font-size: 3rem;"></i>
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
    
    /* Mobile responsive untuk header kalender */
    @media (max-width: 768px) {
        .fc-header-toolbar {
            flex-direction: column;
            gap: 12px;
        }
        .fc-toolbar-chunk {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
        }
        .fc-toolbar-title {
            font-size: 1.2rem !important;
            text-align: center;
        }
        .fc-button {
            padding: 0.3rem 0.6rem !important;
            font-size: 0.8rem !important;
        }
        /* Membuat kalender bisa digeser (scroll) ke samping agar tidak terjepit */
        /* Terapkan overflow hanya pada area grid (harness), BUKAN seluruh kalender termasuk header */
        .fc-view-harness {
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
        }
        .fc-view {
            min-width: 500px;
        }
        /* Hapus min-width dari #calendar agar headernya tetap seukuran layar */
        #calendar {
            min-width: 0 !important;
        }
    }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      themeSystem: 'standard',
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
