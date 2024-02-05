<template>
    <div class="d-inline">
        <i
            class="fa fa-calculator"
            aria-hidden="true"
            @click="calc = !calc"
        ></i>
        <!-- Happy Coding -->
        <div   id="drag" v-if="calc" class="calc bg-light">
            <!-- Calculator Result -->
            <div onclick="dragElement('drag')" id="dragheader"
                class="rounded m-1 p-3 text-right lead font-weight-bold bg-secondary"
            >
                {{ calculatorValue || 0 }}
            </div>

            <!-- Calculator buttons -->
            <div class="row no-gutters">
                <div
                    class="col-3 cursor-pointer"
                    v-for="number in calculatorElements"
                    :key="number"
                >
                    <div
                        class="lead hover text-white text-center m-1 py-3 font-weight-bold bg-secondary rounded"
                        :class="{
                            'bg-success': [
                                'C',
                                '*',
                                '/',
                                '-',
                                '+',
                                '%',
                                '=',
                            ].includes(number),
                        }"
                        @click="calculate(number)"
                    >
                        {{ number }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Calculator",

    data() {
        return {
            calc: false,
            calculatorValue: "",
            calculatorElements: [
                "C",
                "*",
                "/",
                "-",
                7,
                8,
                9,
                "+",
                4,
                5,
                6,
                "%",
                1,
                2,
                3,
                "=",
                0,
                ".",
                this.__("Close"),
            ],
            operator: null,
            previousCalculatorValue: "",
        };
    },

    methods: {
        calculate(n) {
            /* Append value */
            if (!isNaN(n) || n === ".") {
                this.calculatorValue += n + "";
            }

            /* Clear value */
            if (n === "C") {
                this.calculatorValue = "";
            }

            /* Percentage */
            if (n === "%") {
                this.calculatorValue = this.calculatorValue / 100 + "";
            }

            /* Operators */
            if (["/", "*", "-", "+"].includes(n)) {
                this.operator = n;
                this.previousCalculatorValue = this.calculatorValue;
                this.calculatorValue = "";
            }

            /* Calculate result using the eval function */
            if (n === "=") {
                this.calculatorValue = eval(
                    this.previousCalculatorValue +
                        this.operator +
                        this.calculatorValue
                );
                this.previousCalculatorValue = "";
                this.operator = null;
            }
            if (n === this.__("Close")) {
                this.calc = false;
            }
        },
    },
};
</script>

<style scoped>
.hover:hover {
    background: #ffc107 !important;
    color: #fff;
    scale: 1.2;
    transition: 0.2s;
}
.calc {
    position: fixed;
    top: 0;
    z-index: 9999;
    max-width: 400px;
    min-width: 300px;
}


#dragheader {
  cursor: move;
}
</style>
</style>
