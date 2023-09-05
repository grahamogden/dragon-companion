export class Randomiser {
    public randomise(max: number, modifier: number) {
        const rand = Math.ceil(Math.random() * max + modifier);
        const selectedElement = document.querySelector(
            'input[type=text]',
        ) as HTMLInputElement;
        const parentElement = selectedElement.parentElement as HTMLElement;
        const input = parentElement.querySelector('input');
        if (null === input) {
            console.error('No input found for randomizer');
            return;
        }

        return rand;
        // input.value = String(rand);
    }
}
