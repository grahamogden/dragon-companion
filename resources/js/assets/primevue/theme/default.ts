import Aura from "@primevue/themes/aura";
import { definePreset } from "@primevue/themes";

export const defaultTheme = definePreset(Aura, {
    primitive: {
        text: {
            xs: "0.75rem",
            sm: "0.875rem",
            base: "1rem",
            lg: "1.125rem",
            xl: "1.25rem",
            "2xl": "1.5rem",
        },
        biscay: {
            50: "#F1F5FD",
            100: "#DFE9FA",
            200: "#C7D8F6",
            300: "#A1BFEF",
            400: "#749CE6",
            500: "#537BDE",
            600: "#3E5ED2",
            700: "#354CC0",
            800: "#31409C",
            900: "#242F66",
            950: "#1F254C",
        },
        timberwolf: {
            50: "#F8F7F4",
            100: "#EEEDE6",
            150: "#E1DFD8",
            200: "#D9D5CA",
            300: "#C4BEAD",
            400: "#ACA18B",
            500: "#9B8C74",
            600: "#8E7D68",
            700: "#766758",
            800: "#61544B",
            900: "#50473E",
            950: "#2A2420",
        },
        woodsmoke: {
            50: "#F6F5F5",
            100: "#E7E6E6",
            200: "#D2CFCF",
            300: "#B2AEAE",
            400: "#8B8586",
            500: "#706A6B",
            600: "#5F5B5B",
            700: "#514D4D",
            800: "#464445",
            900: "#3D3C3C",
            950: "#1A1919",
            1000: "#100F0F",
        },
        shark: {
            50: "#F7F7F8",
            100: "#EDEDF1",
            200: "#D8D9DF",
            300: "#B5B6C4",
            400: "#8D8FA3",
            500: "#6F7188",
            600: "#595A70",
            700: "#494A5B",
            800: "#3F404D",
            900: "#373743",
            950: "#1E1E24",
        },
        "white-lilac": {
            50: "#FBFBFF",
            100: "#DBDBFE",
            200: "#BFBFFE",
            300: "#9397FD",
            400: "#6062FA",
            500: "#463BF6",
            600: "#3E25EB",
            700: "#3E1DD8",
            800: "#3B1EAF",
            900: "#311E8A",
            950: "#241754",
        },
        "alizarin-crimson": {
            50: "#FFF1F2",
            100: "#FFE1E2",
            200: "#FFC8CB",
            300: "#FFA1A5",
            400: "#FE6B72",
            500: "#F63D45",
            600: "#E01B24",
            700: "#C0151D",
            800: "#9E161C",
            900: "#83191E",
            950: "#48070A",
        },
    },
    semantic: {
        primary: {
            50: "{biscay.50}",
            100: "{biscay.100}",
            200: "{biscay.200}",
            300: "{biscay.300}",
            400: "{biscay.400}",
            500: "{biscay.500}",
            600: "{biscay.600}",
            700: "{biscay.700}",
            800: "{biscay.800}",
            900: "{biscay.900}",
            950: "{biscay.950}",
        },
        colorScheme: {
            dark: {
                formField: {
                    background: "{woodsmoke.950}",
                    border: { color: "{woodsmoke.500}" },
                },
            },
            light: {
                formField: {
                    background: "{timberwolf.50}",
                    border: { color: "{woodsmoke.400}" },
                },
            },
        },
        transition: {
            duration: "0s",
        },
    },
    components: {
        card: {
            title: {
                font: {
                    size: "{text.base}",
                    weight: "bold",
                },
            },
            colorScheme: {
                dark: {
                    background: "{woodsmoke.900}",
                },
                light: {
                    background: "{timberwolf.50}",
                },
            },
        },
        datatable: {
            colorScheme: {
                dark: {
                    body: {
                        cell: {
                            border: {
                                color: "transparent",
                            },
                        },
                    },
                    header: {
                        cell: {
                            background: "{woodsmoke.800}",
                            color: "{white-lilac.50}",
                        },
                    },
                    row: {
                        background: "transparent",
                        striped: {
                            background: "transparent",
                        },
                    },
                },
                light: {
                    body: {
                        cell: {
                            border: {
                                color: "transparent",
                            },
                        },
                    },
                    header: {
                        cell: {
                            background: "{woodsmoke.800}",
                            color: "{white-lilac.50}",
                        },
                    },
                    row: {
                        background: "transparent",
                        striped: {
                            background: "transparent",
                        },
                    },
                },
            },
        },
        select: {
            colorScheme: {
                dark: {
                    option: {
                        focus: {
                            background: "{biscay.800}",
                        },
                        selected: {
                            // background: "transparent",
                            color: "{biscay.300}",
                            focus: {
                                background: "{biscay.800}",
                            },
                        },
                    },
                    overlay: { border: { color: "{woodsmoke.500}" } },
                },
            },
            light: {
                option: {
                    focus: {
                        background: "{biscay.100}",
                    },
                    selected: {
                        // background: "transparent",
                        focus: {
                            background: "{biscay.100}",
                        },
                    },
                },
                overlay: { border: { color: "{woodsmoke.400}" } },
            },
        },
    },
});
