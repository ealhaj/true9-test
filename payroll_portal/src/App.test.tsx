import { render, screen, fireEvent } from "@testing-library/react";
import dayjs from "dayjs";
import App from "./App";
import * as api from "./api/payrolls.api";

const mockUseGetDatesQuery = jest.spyOn(api, "useGetDatesQuery");

const mockData = {
  payment_date: "2023-02-24T00:00:00+00:00",
  pay_date: "2023-02-28T00:00:00+00:00"
};

describe("App Component", () => {
  beforeEach(() => {
    jest.clearAllMocks();
    mockUseGetDatesQuery.mockReturnValue({
      data: mockData,
      error: undefined,
      isLoading: false,
      isSuccess: true,
      isError: false,
      refetch: jest.fn(),
    });
  });

  it('should update UI on month change and display payroll dates', () => {
    render(<App />);

    // values: 1, 2, 3, ...etc
    // indexes: 0, 1, 2, ...etc
    fireEvent.change(screen.getByRole('select'), { target: { value: 2 } });
    const options: HTMLOptionElement[] = screen.getAllByRole('select-option');

    expect(options[0].selected).toBeFalsy();
    expect(options[1].selected).toBeTruthy();
    expect(options[2].selected).toBeFalsy();

    expect(
        screen.getByText(
            `Payment Date: ${dayjs(mockData?.payment_date)
                .utc()
                .format("dddd DD/MM/YYYY")}`
        )
    ).toBeInTheDocument();

    expect(
        screen.getByText(
            `Pay Date: ${dayjs(mockData?.pay_date)
                .utc()
                .format("dddd DD/MM/YYYY")}`
        )
    ).toBeInTheDocument();
  });
});
