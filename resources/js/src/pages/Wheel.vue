<template>
    <div class="content">
        <div class="container-fluid">
            <card>
                <div class="row">
                    <div class="col-12">
                        <FortuneWheel :key="refreshWheel" :use-weight="useWeight" style="width: 500px" :canvas="canvasOptions" :prizes="wheel_users" :verify="canvasVerify" @rotateStart="onCanvasRotateStart" @rotateEnd="onRotateEnd" />
                    </div>
                </div>
            </card>
        </div>
    </div>
</template>
<script>
import FortuneWheel from 'vue-fortune-wheel';
import Swal from 'sweetalert2';
export default {
    components: {
        FortuneWheel,
    },
    data() {
        return {
            winner: null,
            refreshWheel: 0,
            canvasVerify: true, // Whether the turntable in canvas mode is enabled for verification
            useWeight: false,
            canvasOptions: {
                borderColor: '#584b43',
                textDirection: 'vertical',
                textRadius: 290,
                textLength: 10,
                radius: 360,
                lineHeight: 30,
            },
            wheel_users: [],
            prizes: [{
                    id: 1, //* The unique id of each prize, an integer greater than 0
                    name: 'Blue', // Prize name, display value when type is canvas (this parameter is not needed when type is image)
                    value: 'Blue\'s value', //* Prize value, return value after spinning
                    bgColor: '#45ace9', // Background color (no need for this parameter when type is image)
                    color: '#ffffff', // Font color (this parameter is not required when type is image)
                    probability: 25, //* Probability, up to 4 decimal places (the sum of the probabilities of all prizes
                    weight: 1 // Weight, if useWeight is true, the probability is calculated by weight (weight must be an integer), so probability is invalid
                },
                {
                    id: 2,
                    name: 'Red',
                    value: 'Red\'s value',
                    bgColor: '#dd3832',
                    color: '#ffffff',
                    probability: 25,
                    weight: 1
                },
                {
                    id: 3,
                    name: 'Yellow',
                    value: 'Yellow\'s value',
                    bgColor: '#fef151',
                    color: '#ffffff',
                    probability: 25,
                    weight: 1
                },
                {
                    id: 2,
                    name: 'Orange',
                    value: 'Orange value',
                    bgColor: '#dd3832',
                    color: '#ffffff',
                    probability: 25,
                    weight: 1
                },
            ]
        }
    },
    async created() {
        await this.fetch();
    },
    methods: {
        async fetch(page = 1) {
            let { data } = await axios.get('wheel-users');
            this.wheel_users = data.users;
            this.refreshWheel++;
        },
        onImageRotateStart() {
            console.log('onRotateStart')
        },
        onCanvasRotateStart(rotate) {
            console.log(this.canvasVerify);
            if (this.canvasVerify) {
                const verified = true // true: the test passed the verification, false: the test failed the verification
                this.DoServiceVerify(verified, 2000).then((verifiedRes) => {
                    if (verifiedRes) {
                        console.log('Verification passed, start to rotate')
                        rotate() // Call the callback, start spinning
                        this.canvasVerify = false // Turn off verification mode
                    } else {
                        alert('Failed verification')
                    }
                })
                return
            }
            console.log('onCanvasRotateStart');
        },
        async onRotateEnd(prize) {
            this.winner = prize;
            let result = await Swal.fire({
                title: 'Do you want to pass someone else?',
                text: "once confirmed system will recheck the winner",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Pass it',
                cancelButtonText: 'No',
            });
            if (result.isConfirmed) {
                this.canvasVerify = true;
                document.querySelector('.fw-btn__btn').click();

            } else {
                let { data } = await axios.post('announce-winner',{winner : this.winner.id });
                if(data.status){

                    await Swal.fire(
                      'Congratulations!',
                      `${this.winner.name} has been announded as Winner of this month.`,
                      'success'
                    )
                    this.fetch();
                }
            }
        },
        // Simulate the request back-end interface, verified: whether to pass the verification, duration: delay time
        DoServiceVerify(verified, duration) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    resolve(verified)
                }, duration)
            })
        }
    }
}

</script>
