export function debug(input: unknown) {
    console.debug(JSON.parse(JSON.stringify(input)));
}
