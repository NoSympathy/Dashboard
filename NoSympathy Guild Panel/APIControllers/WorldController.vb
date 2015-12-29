Imports APICore
Imports Models
Imports Newtonsoft.Json

Public Class WorldController
    Inherits BaseController
    Public Function GetWorldInfo(Optional worldid As Integer = NosSettings.WorldId) As World
        Dim endPoints = New Uri(Gw2Endpoints.BaseUrl + Gw2Endpoints.World + worldid.ToString())

        Dim jsonRes = GetApiDataByUriJson(endPoints)

        Dim ret = JsonConvert.DeserializeObject(Of World)(jsonRes)

        Return ret
    End Function

    Public Function GetWvWInfo(worldid As Integer) As WvW
        Dim endPoints = New Uri(Gw2Endpoints.BaseUrl + Gw2Endpoints.World + worldid.ToString())

        Dim jsonRes = GetApiDataByUriJson(endPoints)

        Dim ret = JsonConvert.DeserializeObject(Of WvW)(jsonRes)

        Return ret
    End Function
End Class
