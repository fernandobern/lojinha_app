<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Calendário de Agendamentos</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
</head>
<body>

<?php
include('../templates/header.php');

?>
  <div id="calendar"></div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const calendarEl = document.getElementById('calendar');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: '../includes/functions/get_agendamentos.php',

        // 🔹 Datas passadas em vermelho
        dayCellDidMount: function(info) {
          const today = new Date();
          const cellDate = info.date;

          if (cellDate < today.setHours(0,0,0,0)) {
            info.el.style.backgroundColor = "#ffe5e5"; // vermelho claro
            info.el.style.color = "#b00000";           // texto vermelho escuro
          }
        },

        // 🔹 Clique no evento
        eventClick: function(info) {
          alert('Cliente: ' + info.event.title + '\nData: ' + info.event.start.toLocaleString());
        }
      });

      calendar.render();
    });
  </script>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px auto;
      max-width: 900px;
      background: #f9f9f9;
    }

    #calendar {
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    /* 🔹 Impedir que o evento ultrapasse o quadrado */
    .fc-daygrid-day-events {
      max-height: 70px;
      overflow-y: auto;
    }

    .fc-event-title {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>
</body>
</html>
