import { SelectInputOptionInterface } from "../../entity-option";

export enum ChallengeRatingEnum {
    Zero = "0",
    Eighth = "1/8",
    Quarter = "1/4",
    Half = "1/2",
    One = "1",
    Two = "2",
    Three = "3",
    Four = "4",
    Five = "5",
    Six = "6",
    Seven = "7",
    Eight = "8",
    Nine = "9",
    Ten = "10",
    Eleven = "11",
    Twelve = "12",
    Thirteen = "13",
    Fourteen = "14",
    Fifteen = "15",
    Sixteen = "16",
    Seventeen = "17",
    Eighteen = "18",
    Nineteen = "19",
    Twenty = "20",
    TwentyOne = "21",
    TwentyTwo = "22",
    TwentyThree = "23",
    TwentyFour = "24",
    TwentyFive = "25",
    TwentySix = "26",
    TwentySeven = "27",
    TwentyEight = "28",
    TwentyNine = "29",
    Thirty = "30",
}

export class ChallengeRatingUtils {
    static values(): ChallengeRatingEnum[] {
        return Object.values(ChallengeRatingEnum);
    }

    static options(): SelectInputOptionInterface[] {
        return Object.values(ChallengeRatingEnum).map((value) => {
            return {
                text: value,
                value: value,
            };
        });
    }
}
