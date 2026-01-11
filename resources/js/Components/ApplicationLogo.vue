<template>
    <div v-bind="$attrs">
        <img
            src="/logos/pilabank_logo_dark.png"
            alt="PilaBank"
            class="block dark:hidden w-full h-auto object-contain"
        />

        <img
            src="/logos/pilabank_logo_white.png"
            alt="PilaBank"
            class="hidden dark:block w-full h-auto object-contain"
        />
    </div>
</template>
