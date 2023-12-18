import { configureStore } from "@reduxjs/toolkit";
import { payrollApi } from "../api/payrolls.api";

const store = configureStore({
    reducer: {
        [payrollApi.reducerPath]: payrollApi.reducer
    },
    middleware: (getDefaultMiddleware) => {
        return getDefaultMiddleware().concat(payrollApi.middleware);
    }
});

export default store;