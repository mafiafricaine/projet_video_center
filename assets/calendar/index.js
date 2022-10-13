import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

import "./index.css"; // this will create a calendar.css file reachable to 'encore_entry_link_tags'

document.addEventListener("DOMContentLoaded", () => {
  let calendarEl = document.getElementById("calendar-holder");

  let { eventsUrl } = calendarEl.dataset;

  let calendar = new Calendar(calendarEl, {
    editable: true,
    eventSources: [
      {
        url: eventsUrl,
        method: "POST",
        extraParams: {
          filters: JSON.stringify({}) // pass your parameters to the subscriber
        },
        failure: () => {
          // alert("There was an error while fetching FullCalendar!");
        },
      },
    ],
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
    },
    initialView: "dayGridMonth",
    navLinks: true, // can click day/week names to navigate views
    plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
    timeZone: "UTC",
  });

  calendar.render();
});