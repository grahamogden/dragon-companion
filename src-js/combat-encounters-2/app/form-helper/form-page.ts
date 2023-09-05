import {
    MethodNotImplementedException,
    NotFoundException,
} from '../exceptions';

export class FormPage {
    private readonly DISPLAY_BLOCK = 'block';
    private readonly DISPLAY_NONE = 'none';
    // public static readonly PAGE_ID: string;

    protected _fieldset: HTMLFieldSetElement;
    protected _nextButton: HTMLButtonElement | null;
    protected _previousButton: HTMLButtonElement | null;

    constructor(private readonly _pageId: string) {
        this._fieldset = this.initFieldset(_pageId);
        this._nextButton = this.initNextButton();
        this._previousButton = this.initPreviousButton();
    }

    public showPage() {
        this._fieldset.style.display = this.DISPLAY_BLOCK;
    }

    public hidePage() {
        this._fieldset.style.display = this.DISPLAY_NONE;
    }

    public getNextButton(): HTMLButtonElement | null {
        return this._nextButton;
    }

    public getPreviousButton(): HTMLButtonElement | null {
        return this._previousButton;
    }

    protected getSelf() {
        // eslint-disable-next-line @typescript-eslint/no-this-alias
        return this;
    }

    private initNextButton() {
        return this._fieldset.querySelector(
            '.btn.next-step',
        ) as HTMLButtonElement | null;
    }

    private initPreviousButton() {
        return this._fieldset.querySelector(
            '.btn.previous-step',
        ) as HTMLButtonElement | null;
    }

    private initFieldset(pageId: string) {
        const fieldset = document.getElementById(
            pageId,
        ) as HTMLFieldSetElement | null;

        if (null === fieldset) {
            throw new NotFoundException('Fieldset not found');
        }

        return fieldset;
    }

    public get pageId(): string {
        return this._pageId;
    }

    action(): void {
        throw new MethodNotImplementedException(
            'action has not been implemented',
        );
    }

    buildForm(): void {
        throw new MethodNotImplementedException(
            'buildForm has not been implemented',
        );
    }

    isValid(): string[] {
        throw new MethodNotImplementedException(
            'isValid has not been implemented',
        );
    }
}
