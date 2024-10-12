<script setup lang="ts">
    import { ButtonSeverity } from '../../../Components/buttons/button-severity';
    import Button from '../../../Components/buttons/Button.vue';
    import BaseInput from '../../../Components/Fields/BaseInput.vue';
    import CreatorDefaultContentLayout from '../../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';
    import SelectInput from '../../../Components/Fields/SelectInput.vue';
    import LinkButton from '../../../Components/buttons/LinkButton.vue';

</script>
<template>
    <CreatorDefaultContentLayout>
        <div class="flex gap-default w-full">
            <div class="flex items-start gap-default w-full md:w-2/4">
                <Button outlined rounded :severity="ButtonSeverity.success">Button</Button>
                <Button rounded :severity="ButtonSeverity.success">Button</Button>
                <Button outlined disabled :severity="ButtonSeverity.success">Button</Button>
                <Button disabled :severity="ButtonSeverity.success">Button</Button>
            </div>
            <div class="flex items-start gap-default w-full md:w-2/4">
                <LinkButton href="" outlined rounded :severity="ButtonSeverity.success">Button</LinkButton>
                <LinkButton href="" rounded :severity="ButtonSeverity.success">Button</LinkButton>
                <LinkButton href="" outlined disabled :severity="ButtonSeverity.success">Button</LinkButton>
                <LinkButton href="" disabled :severity="ButtonSeverity.success">Button</LinkButton>
            </div>
        </div>
        <div class="flex gap-default w-full">
            <div class="flex items-start gap-default w-full md:w-2/4">
                <Button outlined rounded :severity="ButtonSeverity.danger">Button</Button>
                <Button rounded :severity="ButtonSeverity.danger">Button</Button>
                <Button outlined disabled :severity="ButtonSeverity.danger">Button</Button>
                <Button disabled :severity="ButtonSeverity.danger">Button</Button>
            </div>
            <div class="flex items-start gap-default w-full md:w-2/4">
                <LinkButton href="" outlined rounded :severity="ButtonSeverity.danger">Button</LinkButton>
                <LinkButton href="" rounded :severity="ButtonSeverity.danger">Button</LinkButton>
                <LinkButton href="" outlined disabled :severity="ButtonSeverity.danger">Button</LinkButton>
                <LinkButton href="" disabled :severity="ButtonSeverity.danger">Button</LinkButton>
            </div>
        </div>
        <div class="flex gap-default w-full">
            <div class="flex items-start gap-default w-full md:w-2/4">
                <Button outlined rounded :severity="ButtonSeverity.primary">Button</Button>
                <Button rounded :severity="ButtonSeverity.primary">Button</Button>
                <Button outlined disabled :severity="ButtonSeverity.primary">Button</Button>
                <Button disabled :severity="ButtonSeverity.primary">Button</Button>
            </div>
            <div class="flex items-start gap-default w-full md:w-2/4">
                <LinkButton href="" outlined rounded :severity="ButtonSeverity.primary">Button</LinkButton>
                <LinkButton href="" rounded :severity="ButtonSeverity.primary">Button</LinkButton>
                <LinkButton href="" outlined disabled :severity="ButtonSeverity.primary">Button</LinkButton>
                <LinkButton href="" disabled :severity="ButtonSeverity.primary">Button</LinkButton>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-default md:gap-default-md w-full mb-8">
            <div class="grid gap-default w-full mb-8">
                <BaseInput model="" type="text" input-name="input-text-1" error="" label="Test text">
                </BaseInput>
                <BaseInput model="" type="text" input-name="input-text-2" error="Required" label="Test text">
                </BaseInput>
            </div>
            <div class="grid gap-default w-full mb-8">
                <BaseInput model="" type="number" input-name="input-number-1" error="" label="Test number">
                </BaseInput>
                <BaseInput model="" type="number" input-name="input-number-2" error="Required" label="Test number">
                </BaseInput>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-default md:gap-default-md w-full mb-8">
            <div class="grid gap-default w-full mb-8">
                <BaseInput model="" type="email" input-name="input-email-1" error="" label="Test email">
                </BaseInput>
                <BaseInput model="" type="email" input-name="input-email-2" error="Required" label="Test email">
                </BaseInput>
            </div>
            <div class="grid gap-default w-full mb-8">
                <SelectInput model=""
                    :options="[{ text: '1', value: 1 }, { text: '2', value: 2 }, { text: '3', value: 3 }]"
                    input-name="select-1" error="" label="Test select"></SelectInput>
                <SelectInput model=""
                    :options="[{ text: '1', value: 1 }, { text: '2', value: 2 }, { text: '3', value: 3 }]"
                    input-name="select-2" error="Required" label="Test select"></SelectInput>
            </div>
        </div>
    </CreatorDefaultContentLayout>
</template>