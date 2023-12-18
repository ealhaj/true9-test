import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import React, { useCallback, useState } from "react";
import { useGetDatesQuery } from "./api/payrolls.api";

dayjs.extend(utc);

function App() {
  const [month, setMonth] = useState<number>(1);
  const { data } = useGetDatesQuery({ year: 2023, month: month }) || {};

  const onMonthChange = useCallback(
    (event: React.ChangeEvent<HTMLSelectElement>): void => {
        setMonth(parseInt(event.target.value));
    },
    []
  );

  const months: string[] = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  return (
    <div>
      <select role='select' onChange={onMonthChange} value={month}>
        {months.map((month: string, index: number) => (
          <option role='select-option' key={index} value={index + 1}>
            {month}
          </option>
        ))}
      </select>
      <p>
        {`Payment Date: ${dayjs(data?.payment_date).utc().format("dddd DD/MM/YYYY")}`}
      </p>
      <p>{`Pay Date: ${dayjs(data?.pay_date).utc().format("dddd DD/MM/YYYY")}`}</p>
    </div>
  );
}

export default App;
