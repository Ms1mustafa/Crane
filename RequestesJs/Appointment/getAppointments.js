function getAppointments() {
  $(function () {
    /* initialize the external events
  -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {
        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()), // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data("eventObject", eventObject);
      });
    }

    ini_events($("#external-events div.external-event"));

    /* initialize the calendar
  -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

    var Calendar = FullCalendar.Calendar;
    var calendarEl = document.getElementById("calendar");

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "timeGridDay,timeGridWeek,dayGridMonth",
      },
      themeSystem: "bootstrap",
      events: [
        {
          title: "Lunch time",
          start: new Date(y, m, d, 12, 0),
          end: new Date(y, m, d, 13, 0),
          allDay: false,
          backgroundColor: "#f56954", //Info (aqua)
          borderColor: "#f56954", //Info (aqua)
          extendedProps: {
            source: "constant",
          },
        },
        {
          title: "Dinner time",
          start: new Date(y, m, d, 18, 0),
          end: new Date(y, m, d, 19, 0),
          allDay: false,
          backgroundColor: "#f56954", //Info (aqua)
          borderColor: "#f56954", //Info (aqua)
          extendedProps: {
            source: "constant",
          },
        },
        // ...APIevents,
      ],
      eventDidMount: function (info) {
        // on click show info.event.extendedProps in alert
        info.el.classList.add("event");
        info.el.style.cursor = "pointer";
        $(info.el).click(function () {
          // alert(JSON.stringify(info.event.extendedProps.token, null, 2));
          info.event.extendedProps.requester &&
            Swal.fire({
              title: info.event.title,
              html: `
            <p>Requester: ${info.event.extendedProps.requester}</p>
            <p>Area: ${info.event.extendedProps.area}</p>
            <p>Location: ${info.event.extendedProps.location}</p>
            <p>Work Type: ${info.event.extendedProps.work_type}</p>
            `,
              showConfirmButton: false,
              showCloseButton: true,
              allowEnterKey: false,
            });
        });
      },
      editable: false,
      droppable: false,
      initialView: "timeGridDay",
    });

    calendar.render();

    // Function to fetch and render events periodically
    async function fetchAndRenderEvents() {
      const getAppointmentUrl = "../Requestes/Appointment/GetAppointments.php";
      try {
        const response = await axios.post(
          getAppointmentUrl,
          { eq: getUrlParam("eq") },
          { headers: { "Content-Type": "application/x-www-form-urlencoded" } }
        );
        const data = response.data;
        if (data.success) {
          username.innerHTML = `User Name: ${capitalizeFirst(
            data.basic_data.username
          )}`;
          rqNo.textContent = `Rq NO: ${data.basic_data.rqNo}`;
          typeAset.textContent = `Type Aset: ${data.basic_data.asset_type}`;
          // Clear existing events on the calendar
          calendar.getEvents().forEach((event) => {
            if (
              event.extendedProps &&
              event.extendedProps.source !== "constant"
            ) {
              event.remove();
            }
          });

          // Add events from API response
          calendar.addEventSource(data.appointments);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    }

    // Render events initially and then every 5 minutes
    fetchAndRenderEvents();
    setInterval(fetchAndRenderEvents, 3 * 60 * 1000); // 5 minutes in milliseconds
  });
}
getAppointments();
