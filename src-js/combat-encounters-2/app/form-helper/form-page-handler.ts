import { FormPage } from './form-page';

export class FormPageHandler {
    private _currentPage = 0;
    private _pages: FormPage[] = [];

    constructor() {
        // this._stage = 0;
        // // eslint-disable-next-line @typescript-eslint/no-this-alias
        // const self = this;
        //
        // console.debug(fieldsetIds);
        // fieldsetIds.forEach((fieldsetId) => {
        //     const fieldset = document.getElementById(
        //         fieldsetId,
        //     ) as HTMLFieldSetElement | null;
        //     console.debug(fieldset);
        //     if (null === fieldset) {
        //         throw new NotFoundException('Fieldset not found');
        //     }
        //
        //     const submit = fieldset.querySelector(
        //         '.btn-success',
        //     ) as HTMLButtonElement;
        //     console.debug('submit');
        //     console.debug(submit);
        //     submit.addEventListener('click', function (event) {
        //         event.preventDefault();
        //         console.debug('Clicked next!');
        //         if (!self.nextStage()) {
        //         }
        //     });
        //
        //     this._fieldsets.push(fieldset);
        // });
    }

    /**
     * @param page
     * @param pageRules - List of methods to run to ensure validation has passed
     */
    public addPage(page: FormPage): void {
        this.attachClickEventForNextButton(page);
        this.attachClickEventForPreviousButton(page);

        this._pages.push(page);
    }

    private getCurrentPage(): FormPage {
        return this._pages[this._currentPage];
    }

    public nextPage(): void {
        // console.debug('Clicked next!');
        const currentPage = this.getCurrentPage();
        const errorMessages = currentPage.isValid();
        if (errorMessages.length > 0) {
            errorMessages.forEach((errorMessage: string) => {
                alert(errorMessage);
                console.error(errorMessage);
            });

            console.error('Page not valid');
            return;
        }

        console.debug('Executing action!');
        currentPage.action();
        currentPage.hidePage();

        ++this._currentPage;
        const nextPage = this.getCurrentPage();
        nextPage.buildForm();
        nextPage.showPage();
    }

    private attachClickEventForNextButton(page: FormPage): void {
        // eslint-disable-next-line @typescript-eslint/no-this-alias
        const self = this;
        const button = page.getNextButton();

        button?.addEventListener('click', function (event) {
            event.preventDefault();
            self.nextPage();
            // if (!page.isValid()) {
            //     console.debug('Is not valid');
            //     return;
            // }
            //
            // console.debug('Executing action!');
            // page.action();
        });
        // $('fieldset button.next-step').on('click', function () {
        //     let $parent = $(this).closest('fieldset');
        //     $($parent).hide();
        //     let $next = $($parent).next('fieldset');
        //     $($next).show();
        //     $($next)
        //         .find('input[type=text],input[type=hidden],select,textarea')
        //         .val('');
        // });
    }

    public previousPage(): void {
        // console.debug('Clicked previous!');
        const currentPage = this.getCurrentPage();
        currentPage.hidePage();

        --this._currentPage;
        const previousPage = this.getCurrentPage();
        previousPage.buildForm();
        previousPage.showPage();
    }

    private attachClickEventForPreviousButton(page: FormPage): void {
        // eslint-disable-next-line @typescript-eslint/no-this-alias
        const self = this;
        const button = page.getPreviousButton();

        button?.addEventListener('click', function (event) {
            event.preventDefault();
            self.previousPage();
            // console.debug('Clicked next!');
            // if (!page.isValid()) {
            //     console.debug('Is not valid');
            //     return;
            // }
            //
            // console.debug('Executing action!');
            // page.action();
        });
        // $('fieldset button.previous-step').on('click', function () {
        //     let $parent = $(this).closest('fieldset');
        //     $($parent).find('table.autocomplete-table tbody tr').remove();
        //     $($parent)
        //         .hide()
        //         .find('input[type=text],input[type=hidden],select,textarea')
        //         .val('');
        //     $($parent).prev('fieldset').show();
        // });
    }

    public goToPageById(pageId: string): void {
        let pageToOpenId: number | undefined;
        this._pages.forEach((formPage, index) => {
            formPage.hidePage();

            if (formPage.pageId === pageId) {
                pageToOpenId = index;
            }
        });

        // Page found, so open it
        if (typeof pageToOpenId !== 'undefined') {
            this._currentPage = pageToOpenId;
            const nextPage = this._pages[this._currentPage];
            nextPage.buildForm();
            nextPage.showPage();
            return;
        }

        console.error(`Page could not be found to open - ${pageId}`);
    }
}
