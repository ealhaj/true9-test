import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

export interface IPayrollDatesGet {
  payment_date: string;
  pay_date: string;
}

interface IPayrollDateParams {
  year: number;
  month: number;
}

const payrollApi = createApi({
  reducerPath: "payrolls",
  baseQuery: fetchBaseQuery({
    baseUrl: "http://localhost/v1/api",
    headers: {
      "Content-Type": "application/json",
    },
  }),
  endpoints: (builder) => ({
    getDates: builder.query<IPayrollDatesGet, IPayrollDateParams>({
      query: (args) => ({
        url: "/payrolls/dates",
        params: {
          year: args.year,
          month: args.month,
        },
        method: "GET",
      }),
    }),
  }),
});

export const { useGetDatesQuery } = payrollApi;
export { payrollApi };
