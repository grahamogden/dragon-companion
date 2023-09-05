export interface FormPageInterface {
    // PAGE_ID: string;
    // readonly pageId: string;

    action(): void;
    buildForm(): void;
    isValid(): string[];
}
